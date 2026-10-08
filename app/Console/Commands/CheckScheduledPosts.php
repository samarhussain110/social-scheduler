<?php

namespace App\Console\Commands;

use App\Jobs\FacebookPublishJob;
use App\Jobs\InstagramPublishJob;
use App\Jobs\LinkedInPublishJob;
use App\Models\ScheduledPost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:check-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for scheduled posts that are due for publishing and dispatch publishing jobs';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Checking for scheduled posts due for publishing...');

        // Get posts that are due for publishing
        $duePosts = ScheduledPost::dueForPublishing()->get();

        if ($duePosts->isEmpty()) {
            $this->info('No posts due for publishing.');
            return Command::SUCCESS;
        }

        $this->info("Found {$duePosts->count()} posts due for publishing.");

        foreach ($duePosts as $post) {
            try {
                // Update status to indicate it's being processed
                $post->update(['status' => 'pending']);

                // Dispatch the appropriate job based on platform
                switch ($post->platform) {
                    case 'facebook':
                        FacebookPublishJob::dispatch($post);
                        $this->info("Dispatched FacebookPublishJob for post ID: {$post->id}");
                        break;

                    case 'instagram':
                        InstagramPublishJob::dispatch($post);
                        $this->info("Dispatched InstagramPublishJob for post ID: {$post->id}");
                        break;

                    case 'linkedin':
                        LinkedInPublishJob::dispatch($post);
                        $this->info("Dispatched LinkedInPublishJob for post ID: {$post->id}");
                        break;

                    default:
                        $this->warn("Unknown platform '{$post->platform}' for post ID: {$post->id}");
                        $post->markAsFailed("Unknown platform: {$post->platform}");
                        break;
                }

            } catch (\Exception $e) {
                $this->error("Failed to dispatch job for post ID: {$post->id}. Error: {$e->getMessage()}");
                Log::error("CheckScheduledPosts: Failed to dispatch job for post {$post->id}. Error: " . $e->getMessage());
                $post->markAsFailed($e->getMessage());
            }
        }

        $this->info('Scheduled posts check completed.');
        return Command::SUCCESS;
    }
}
