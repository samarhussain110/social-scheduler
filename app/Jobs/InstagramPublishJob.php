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

class InstagramPublishJob implements ShouldQueue
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
            Log::info("InstagramPublishJob: Post {$this->scheduledPost->id} is not in publishable state. Status: {$this->scheduledPost->status}");
            return;
        }

        // Get social account
        $socialAccount = $this->scheduledPost->socialAccount;

        if (!$socialAccount || $socialAccount->platform !== 'instagram') {
            $this->scheduledPost->markAsFailed('Invalid or missing Instagram social account.');
            return;
        }

        // Instagram requires media to publish
        if ($this->scheduledPost->media->isEmpty()) {
            $this->scheduledPost->markAsFailed('Instagram posts require at least one media file (image or video).');
            return;
        }

        try {
            // Update status to publishing
            $this->scheduledPost->update(['status' => 'publishing']);

            $firstMedia = $this->scheduledPost->media->first();
            $mediaPath = storage_path('app/public/' . $firstMedia->file_path);

            if ($firstMedia->media_type === 'image') {
                $this->publishImage($socialAccount, $mediaPath);
            } elseif ($firstMedia->media_type === 'video') {
                $this->publishVideo($socialAccount, $mediaPath);
            } else {
                throw new \Exception('Unsupported media type for Instagram.');
            }

        } catch (\Exception $e) {
            Log::error("InstagramPublishJob: Failed to publish post {$this->scheduledPost->id}. Error: " . $e->getMessage());
            $this->scheduledPost->markAsFailed($e->getMessage());
        }
    }

    /**
     * Publish an image to Instagram.
     */
    protected function publishImage(SocialAccount $socialAccount, string $mediaPath): void
    {
        // Step 1: Create a container
        $containerResponse = Http::post(
            "https://graph.instagram.com/v18.0/me/media",
            [
                'image_url' => asset('storage/' . $this->scheduledPost->media->first()->file_path),
                'caption' => $this->scheduledPost->content,
                'access_token' => $socialAccount->access_token,
            ]
        );

        if (!$containerResponse->successful()) {
            $errorData = $containerResponse->json();
            $errorMessage = $errorData['error']['message'] ?? 'Instagram container creation failed.';
            
            // Handle rate limiting
            if ($containerResponse->status() === 429) {
                $retryAfter = $containerResponse->header('Retry-After', 3600);
                $this->release($retryAfter);
                Log::warning("InstagramPublishJob: Rate limited. Will retry after {$retryAfter} seconds.");
                return;
            }

            throw new \Exception($errorMessage);
        }

        $containerData = $containerResponse->json();
        $containerId = $containerData['id'] ?? null;

        if (!$containerId) {
            throw new \Exception('Instagram did not return container ID.');
        }

        // Step 2: Publish the container
        $publishResponse = Http::post(
            "https://graph.instagram.com/v18.0/me/media_publish",
            [
                'creation_id' => $containerId,
                'access_token' => $socialAccount->access_token,
            ]
        );

        if (!$publishResponse->successful()) {
            $errorData = $publishResponse->json();
            $errorMessage = $errorData['error']['message'] ?? 'Instagram publish failed.';
            throw new \Exception($errorMessage);
        }

        $publishData = $publishResponse->json();
        $postId = $publishData['id'] ?? null;

        if (!$postId) {
            throw new \Exception('Instagram did not return post ID.');
        }

        // Mark as published
        $this->scheduledPost->markAsPublished($postId, $publishData);
        Log::info("InstagramPublishJob: Image post {$this->scheduledPost->id} published successfully. Post ID: {$postId}");
    }

    /**
     * Publish a video to Instagram.
     */
    protected function publishVideo(SocialAccount $socialAccount, string $mediaPath): void
    {
        // Step 1: Create a video container
        $containerResponse = Http::asMultipart()->post(
            "https://graph.instagram.com/v18.0/me/media",
            [
                'video_url' => asset('storage/' . $this->scheduledPost->media->first()->file_path),
                'caption' => $this->scheduledPost->content,
                'access_token' => $socialAccount->access_token,
            ]
        );

        if (!$containerResponse->successful()) {
            $errorData = $containerResponse->json();
            $errorMessage = $errorData['error']['message'] ?? 'Instagram video container creation failed.';
            
            // Handle rate limiting
            if ($containerResponse->status() === 429) {
                $retryAfter = $containerResponse->header('Retry-After', 3600);
                $this->release($retryAfter);
                Log::warning("InstagramPublishJob: Rate limited. Will retry after {$retryAfter} seconds.");
                return;
            }

            throw new \Exception($errorMessage);
        }

        $containerData = $containerResponse->json();
        $containerId = $containerData['id'] ?? null;

        if (!$containerId) {
            throw new \Exception('Instagram did not return video container ID.');
        }

        // Step 2: Wait for video processing (Instagram requires this)
        $this->waitForVideoProcessing($socialAccount, $containerId);

        // Step 3: Publish the container
        $publishResponse = Http::post(
            "https://graph.instagram.com/v18.0/me/media_publish",
            [
                'creation_id' => $containerId,
                'access_token' => $socialAccount->access_token,
            ]
        );

        if (!$publishResponse->successful()) {
            $errorData = $publishResponse->json();
            $errorMessage = $errorData['error']['message'] ?? 'Instagram video publish failed.';
            throw new \Exception($errorMessage);
        }

        $publishData = $publishResponse->json();
        $postId = $publishData['id'] ?? null;

        if (!$postId) {
            throw new \Exception('Instagram did not return video post ID.');
        }

        // Mark as published
        $this->scheduledPost->markAsPublished($postId, $publishData);
        Log::info("InstagramPublishJob: Video post {$this->scheduledPost->id} published successfully. Post ID: {$postId}");
    }

    /**
     * Wait for Instagram video processing to complete.
     */
    protected function waitForVideoProcessing(SocialAccount $socialAccount, string $containerId): void
    {
        $maxAttempts = 20; // Maximum 20 attempts
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            $statusResponse = Http::get(
                "https://graph.instagram.com/v18.0/{$containerId}",
                [
                    'fields' => 'status',
                    'access_token' => $socialAccount->access_token,
                ]
            );

            if ($statusResponse->successful()) {
                $statusData = $statusResponse->json();
                $status = $statusData['status'] ?? null;

                if ($status === 'FINISHED') {
                    return; // Video is ready
                } elseif ($status === 'ERROR') {
                    throw new \Exception('Instagram video processing failed.');
                }
            }

            // Wait 5 seconds before checking again
            sleep(5);
            $attempt++;
        }

        throw new \Exception('Instagram video processing timed out.');
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("InstagramPublishJob: Job failed for post {$this->scheduledPost->id}. Error: " . $exception->getMessage());
        $this->scheduledPost->markAsFailed($exception->getMessage());
    }
}
