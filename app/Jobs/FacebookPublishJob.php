<?php

namespace App\Jobs;

use App\Models\ScheduledPost;
use App\Models\SocialAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacebookPublishJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [60, 300, 900]; // 1min, 5min, 15min

    protected $scheduledPost;

    /**
     * Create a new job instance.
     */
    public function __construct(ScheduledPost $scheduledPost)
    {
        $this->scheduledPost = $scheduledPost;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Refresh the post from database to get latest state
        $this->scheduledPost->refresh();

        // Check if post is still in a publishable state
        if (!in_array($this->scheduledPost->status, ['pending', 'scheduled'])) {
            Log::info("FacebookPublishJob: Post {$this->scheduledPost->id} is not in publishable state. Status: {$this->scheduledPost->status}");
            return;
        }

        // Get social account
        $socialAccount = $this->scheduledPost->socialAccount;

        if (!$socialAccount || $socialAccount->platform !== 'facebook') {
            $this->scheduledPost->markAsFailed('Invalid or missing Facebook social account.');
            return;
        }

        // Check if token is expired
        if ($socialAccount->token_expires_at && $socialAccount->token_expires_at->isPast()) {
            $this->scheduledPost->markAsFailed('Facebook access token has expired. Please reconnect your account.');
            return;
        }

        try {
            // Update status to publishing
            $this->scheduledPost->update(['status' => 'publishing']);

            $graphApi = 'https://graph.facebook.com/v18.0';
            $pagesResponse = Http::get("{$graphApi}/me/accounts", [
                'fields' => 'id,name,access_token',
                'access_token' => $socialAccount->access_token,
            ]);

            if (!$pagesResponse->successful()) {
                throw new \Exception('Unable to retrieve Facebook Pages: ' . $pagesResponse->body());
            }

            $page = $pagesResponse->json('data.0');

            if (empty($page['id']) || empty($page['access_token'])) {
                throw new \Exception('No Facebook Page with a publishing access token was found.');
            }

            // Prepare post data
            $postData = [
                'message' => $this->scheduledPost->content,
            ];

            $endpoint = "{$graphApi}/{$page['id']}/feed";

            // Handle media upload if present
            if ($this->scheduledPost->media->isNotEmpty()) {
                $firstMedia = $this->scheduledPost->media->first();

                if ($firstMedia->media_type === 'image') {
                    $imageFile = fopen(storage_path('app/public/' . $firstMedia->file_path), 'r');

                    if ($imageFile === false) {
                        throw new \Exception('Unable to open Facebook image for upload.');
                    }

                    try {
                        $imageUploadResponse = Http::asMultipart()->post(
                            "{$graphApi}/{$page['id']}/photos",
                            [
                                'source' => $imageFile,
                                'caption' => $this->scheduledPost->content,
                                'access_token' => $page['access_token'],
                                'published' => 'true',
                            ]
                        );
                    } finally {
                        fclose($imageFile);
                    }

                    if (!$imageUploadResponse->successful()) {
                        throw new \Exception('Facebook image upload failed: ' . $imageUploadResponse->body());
                    }

                    $imageData = $imageUploadResponse->json();
                    $postId = $imageData['post_id'] ?? $imageData['id'] ?? null;

                    if (!$postId) {
                        throw new \Exception('Facebook did not return post ID.');
                    }

                    $this->scheduledPost->markAsPublished($postId, $imageData);
                    Log::info("FacebookPublishJob: Image post {$this->scheduledPost->id} published successfully. Post ID: {$postId}");
                    return;

                } elseif ($firstMedia->media_type === 'video') {
                    $videoFile = fopen(storage_path('app/public/' . $firstMedia->file_path), 'r');

                    if ($videoFile === false) {
                        throw new \Exception('Unable to open Facebook video for upload.');
                    }

                    try {
                        $videoUploadResponse = Http::asMultipart()->post(
                            "{$graphApi}/{$page['id']}/videos",
                            [
                                'source' => $videoFile,
                                'description' => $this->scheduledPost->content,
                                'access_token' => $page['access_token'],
                            ]
                        );
                    } finally {
                        fclose($videoFile);
                    }

                    if (!$videoUploadResponse->successful()) {
                        throw new \Exception('Facebook video upload failed: ' . $videoUploadResponse->body());
                    }

                    $videoData = $videoUploadResponse->json();
                    $postId = $videoData['id'] ?? null;

                    if (!$postId) {
                        throw new \Exception('Facebook did not return video ID.');
                    }

                    // Mark as published
                    $this->scheduledPost->markAsPublished($postId, $videoData);
                    Log::info("FacebookPublishJob: Video post {$this->scheduledPost->id} published successfully. Post ID: {$postId}");
                    return;
                }
            }

            // Add access token
            $postData['access_token'] = $page['access_token'];

            // Make the API call
            $response = Http::post($endpoint, $postData);

            if (!$response->successful()) {
                $errorData = $response->json();
                $errorMessage = $errorData['error']['message'] ?? 'Facebook API error.';
                
                // Handle rate limiting
                if ($response->status() === 429) {
                    $retryAfter = $response->header('Retry-After', 3600);
                    $this->release($retryAfter);
                    Log::warning("FacebookPublishJob: Rate limited. Will retry after {$retryAfter} seconds.");
                    return;
                }

                throw new \Exception($errorMessage);
            }

            $responseData = $response->json();
            $postId = $responseData['id'] ?? null;

            if (!$postId) {
                throw new \Exception('Facebook did not return post ID.');
            }

            // Mark as published
            $this->scheduledPost->markAsPublished($postId, $responseData);
            Log::info("FacebookPublishJob: Post {$this->scheduledPost->id} published successfully. Post ID: {$postId}");

        } catch (\Exception $e) {
            Log::error("FacebookPublishJob: Failed to publish post {$this->scheduledPost->id}. Error: " . $e->getMessage());
            $this->scheduledPost->markAsFailed($e->getMessage());
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("FacebookPublishJob: Job failed for post {$this->scheduledPost->id}. Error: " . $exception->getMessage());
        $this->scheduledPost->markAsFailed($exception->getMessage());
    }
}
