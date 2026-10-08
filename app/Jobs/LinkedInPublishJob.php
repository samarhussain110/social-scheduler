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

class LinkedInPublishJob implements ShouldQueue
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
            Log::info("LinkedInPublishJob: Post {$this->scheduledPost->id} is not in publishable state. Status: {$this->scheduledPost->status}");
            return;
        }

        // Get social account
        $socialAccount = $this->scheduledPost->socialAccount;

        if (!$socialAccount || $socialAccount->platform !== 'linkedin') {
            $this->scheduledPost->markAsFailed('Invalid or missing LinkedIn social account.');
            return;
        }

        // Check if token is expired
        if ($socialAccount->token_expires_at && $socialAccount->token_expires_at->isPast()) {
            $this->scheduledPost->markAsFailed('LinkedIn access token has expired. Please reconnect your account.');
            return;
        }

        try {
            // Update status to publishing
            $this->scheduledPost->update(['status' => 'publishing']);

            // Get LinkedIn person URN
            $personUrn = $this->getLinkedInPersonUrn($socialAccount);

            if (!$personUrn) {
                throw new \Exception('Could not retrieve LinkedIn person URN.');
            }

            // Prepare post data
            $postData = [
                'author' => $personUrn,
                'lifecycleState' => 'PUBLISHED',
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => [
                        'shareCommentary' => [
                            'text' => $this->scheduledPost->content,
                        ],
                        'shareMediaCategory' => 'NONE',
                    ],
                ],
                'visibility' => [
                    'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC',
                ],
            ];

            // Handle media upload if present
            if ($this->scheduledPost->media->isNotEmpty()) {
                $firstMedia = $this->scheduledPost->media->first();

                if ($firstMedia->media_type === 'image') {
                    $mediaUrn = $this->uploadLinkedInImage($socialAccount, $firstMedia);
                    
                    if ($mediaUrn) {
                        $postData['specificContent']['com.linkedin.ugc.ShareContent']['shareMediaCategory'] = 'IMAGE';
                        $postData['specificContent']['com.linkedin.ugc.ShareContent']['media'] = [
                            [
                                'status' => 'READY',
                                'description' => [
                                    'text' => $firstMedia->caption ?? '',
                                ],
                                'media' => $mediaUrn,
                                'title' => [
                                    'text' => $firstMedia->file_name,
                                ],
                            ],
                        ];
                    }
                } elseif ($firstMedia->media_type === 'video') {
                    $mediaUrn = $this->uploadLinkedInVideo($socialAccount, $firstMedia);
                    
                    if ($mediaUrn) {
                        $postData['specificContent']['com.linkedin.ugc.ShareContent']['shareMediaCategory'] = 'VIDEO';
                        $postData['specificContent']['com.linkedin.ugc.ShareContent']['media'] = [
                            [
                                'status' => 'READY',
                                'description' => [
                                    'text' => $firstMedia->caption ?? '',
                                ],
                                'media' => $mediaUrn,
                                'title' => [
                                    'text' => $firstMedia->file_name,
                                ],
                            ],
                        ];
                    }
                }
            }

            // Make the API call to create the post
            $response = Http::withToken($socialAccount->access_token)
                ->post(
                    'https://api.linkedin.com/v2/ugcPosts',
                    $postData
                );

            if (!$response->successful()) {
                $errorData = $response->json();
                $errorMessage = $errorData['message'] ?? $errorData['error'] ?? 'LinkedIn API error.';
                
                // Handle rate limiting
                if ($response->status() === 429) {
                    $retryAfter = $response->header('X-RestLi-Remaining', 3600);
                    $this->release($retryAfter);
                    Log::warning("LinkedInPublishJob: Rate limited. Will retry after {$retryAfter} seconds.");
                    return;
                }

                throw new \Exception($errorMessage);
            }

            $responseData = $response->json();
            $postId = $responseData['id'] ?? null;

            if (!$postId) {
                throw new \Exception('LinkedIn did not return post ID.');
            }

            // Mark as published
            $this->scheduledPost->markAsPublished($postId, $responseData);
            Log::info("LinkedInPublishJob: Post {$this->scheduledPost->id} published successfully. Post ID: {$postId}");

        } catch (\Exception $e) {
            Log::error("LinkedInPublishJob: Failed to publish post {$this->scheduledPost->id}. Error: " . $e->getMessage());
            $this->scheduledPost->markAsFailed($e->getMessage());
        }
    }

    /**
     * Get LinkedIn person URN.
     */
    protected function getLinkedInPersonUrn(SocialAccount $socialAccount): ?string
    {
        $response = Http::withToken($socialAccount->access_token)
            ->get('https://api.linkedin.com/v2/userinfo');

        if ($response->successful()) {
            $data = $response->json();
            $sub = $data['sub'] ?? null;
            
            if ($sub) {
                return "urn:li:person:{$sub}";
            }
        }

        return null;
    }

    /**
     * Upload an image to LinkedIn.
     */
    protected function uploadLinkedInImage(SocialAccount $socialAccount, $media): ?string
    {
        // Step 1: Register upload
        $registerResponse = Http::withToken($socialAccount->access_token)
            ->post('https://api.linkedin.com/v2/assets?action=registerUpload', [
                'registerUploadRequest' => [
                    'owner' => $this->getLinkedInPersonUrn($socialAccount),
                    'recipes' => [
                        'urn:li:digitalmediaAsset:urn:li:digitalmediaRecipe:(feed,images,asset)',
                    ],
                    'serviceMetadatas' => [
                        [
                            'serviceName' => 'LIG0UPA',
                        ],
                    ],
                ],
            ]);

        if (!$registerResponse->successful()) {
            Log::error("LinkedInPublishJob: Image registration failed. " . $registerResponse->body());
            return null;
        }

        $registerData = $registerResponse->json();
        $uploadUrl = $registerData['value']['uploadMechanism']['com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest']['uploadUrl'] ?? null;
        $assetUrn = $registerData['value']['asset'] ?? null;

        if (!$uploadUrl || !$assetUrn) {
            return null;
        }

        // Step 2: Upload the image
        $uploadResponse = Http::asMultipart()->put(
            $uploadUrl,
            [
                'file' => fopen(storage_path('app/public/' . $media->file_path), 'r'),
            ],
            [
                'Authorization' => 'Bearer ' . $socialAccount->access_token,
            ]
        );

        if (!$uploadResponse->successful()) {
            Log::error("LinkedInPublishJob: Image upload failed. " . $uploadResponse->body());
            return null;
        }

        return $assetUrn;
    }

    /**
     * Upload a video to LinkedIn.
     */
    protected function uploadLinkedInVideo(SocialAccount $socialAccount, $media): ?string
    {
        // Step 1: Register upload
        $registerResponse = Http::withToken($socialAccount->access_token)
            ->post('https://api.linkedin.com/v2/assets?action=registerUpload', [
                'registerUploadRequest' => [
                    'owner' => $this->getLinkedInPersonUrn($socialAccount),
                    'recipes' => [
                        'urn:li:digitalmediaAsset:urn:li:digitalmediaRecipe:(feed,video,asset)',
                    ],
                    'serviceMetadatas' => [
                        [
                            'serviceName' => 'LIG0UPA',
                        ],
                    ],
                ],
            ]);

        if (!$registerResponse->successful()) {
            Log::error("LinkedInPublishJob: Video registration failed. " . $registerResponse->body());
            return null;
        }

        $registerData = $registerResponse->json();
        $uploadUrl = $registerData['value']['uploadMechanism']['com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest']['uploadUrl'] ?? null;
        $assetUrn = $registerData['value']['asset'] ?? null;

        if (!$uploadUrl || !$assetUrn) {
            return null;
        }

        // Step 2: Upload the video
        $uploadResponse = Http::asMultipart()->put(
            $uploadUrl,
            [
                'file' => fopen(storage_path('app/public/' . $media->file_path), 'r'),
            ],
            [
                'Authorization' => 'Bearer ' . $socialAccount->access_token,
            ]
        );

        if (!$uploadResponse->successful()) {
            Log::error("LinkedInPublishJob: Video upload failed. " . $uploadResponse->body());
            return null;
        }

        return $assetUrn;
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("LinkedInPublishJob: Job failed for post {$this->scheduledPost->id}. Error: " . $exception->getMessage());
        $this->scheduledPost->markAsFailed($exception->getMessage());
    }
}
