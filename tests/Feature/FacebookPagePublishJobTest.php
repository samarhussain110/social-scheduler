<?php

namespace Tests\Feature;

use App\Jobs\FacebookPublishJob;
use App\Models\PostMedia;
use App\Models\ScheduledPost;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FacebookPagePublishJobTest extends TestCase
{
    use RefreshDatabase;

    private string $mediaPath = 'post-media/facebook-page-publish-test.png';

    protected function tearDown(): void
    {
        Storage::disk('public')->delete($this->mediaPath);

        parent::tearDown();
    }

    public function test_image_is_published_to_the_first_facebook_page_with_its_page_token(): void
    {
        $user = User::factory()->create();
        $socialAccount = SocialAccount::create([
            'user_id' => $user->id,
            'platform' => 'facebook',
            'account_name' => 'Facebook Account',
            'account_id' => 'facebook-user-id',
            'access_token' => 'user-access-token',
            'status' => 'connected',
        ]);
        $post = ScheduledPost::create([
            'user_id' => $user->id,
            'platform' => 'facebook',
            'social_account_id' => $socialAccount->id,
            'content' => 'Scheduled Facebook image',
            'status' => 'scheduled',
            'scheduled_at' => now()->subMinute(),
            'timezone' => 'UTC',
        ]);

        Storage::disk('public')->put($this->mediaPath, 'test image');
        PostMedia::create([
            'scheduled_post_id' => $post->id,
            'media_type' => 'image',
            'file_path' => $this->mediaPath,
            'file_name' => 'test.png',
            'mime_type' => 'image/png',
            'file_size' => 10,
            'order' => 0,
        ]);

        Http::fake([
            'https://graph.facebook.com/v18.0/me/accounts*' => Http::response([
                'data' => [
                    ['id' => 'first-page', 'access_token' => 'first-page-token'],
                    ['id' => 'second-page', 'access_token' => 'second-page-token'],
                ],
            ]),
            'https://graph.facebook.com/v18.0/first-page/photos' => Http::response([
                'id' => 'photo-id',
                'post_id' => 'published-post-id',
            ]),
        ]);

        (new FacebookPublishJob($post))->handle();

        $post->refresh();
        $this->assertSame('published', $post->status);
        $this->assertSame('published-post-id', $post->platform_post_id);
        $this->assertNull($post->error_message);

        Http::assertSent(function ($request) {
            if ($request->method() !== 'GET'
                || parse_url($request->url(), PHP_URL_PATH) !== '/v18.0/me/accounts') {
                return false;
            }

            parse_str((string) parse_url($request->url(), PHP_URL_QUERY), $query);

            return ($query['access_token'] ?? null) === 'user-access-token'
                && ($query['fields'] ?? null) === 'id,name,access_token';
        });

        Http::assertSent(function ($request) {
            return $request->method() === 'POST'
                && parse_url($request->url(), PHP_URL_PATH) === '/v18.0/first-page/photos';
        });
    }

    public function test_text_post_is_published_to_the_facebook_page_feed(): void
    {
        $user = User::factory()->create();
        $socialAccount = SocialAccount::create([
            'user_id' => $user->id,
            'platform' => 'facebook',
            'account_name' => 'Facebook Account',
            'account_id' => 'facebook-user-id',
            'access_token' => 'user-access-token',
            'status' => 'connected',
        ]);
        $post = ScheduledPost::create([
            'user_id' => $user->id,
            'platform' => 'facebook',
            'social_account_id' => $socialAccount->id,
            'content' => 'Scheduled Facebook text',
            'status' => 'scheduled',
            'scheduled_at' => now()->subMinute(),
            'timezone' => 'UTC',
        ]);

        Http::fake([
            'https://graph.facebook.com/v18.0/me/accounts*' => Http::response([
                'data' => [
                    ['id' => 'first-page', 'access_token' => 'first-page-token'],
                ],
            ]),
            'https://graph.facebook.com/v18.0/first-page/feed' => Http::response([
                'id' => 'published-text-post-id',
            ]),
        ]);

        (new FacebookPublishJob($post))->handle();

        $post->refresh();
        $this->assertSame('published', $post->status);
        $this->assertSame('published-text-post-id', $post->platform_post_id);

        Http::assertSent(function ($request) {
            return $request->method() === 'POST'
                && parse_url($request->url(), PHP_URL_PATH) === '/v18.0/first-page/feed'
                && $request['access_token'] === 'first-page-token'
                && $request['message'] === 'Scheduled Facebook text';
        });
    }

    public function test_video_is_uploaded_to_the_facebook_page(): void
    {
        $user = User::factory()->create();
        $socialAccount = SocialAccount::create([
            'user_id' => $user->id,
            'platform' => 'facebook',
            'account_name' => 'Facebook Account',
            'account_id' => 'facebook-user-id',
            'access_token' => 'user-access-token',
            'status' => 'connected',
        ]);
        $post = ScheduledPost::create([
            'user_id' => $user->id,
            'platform' => 'facebook',
            'social_account_id' => $socialAccount->id,
            'content' => 'Scheduled Facebook video',
            'status' => 'scheduled',
            'scheduled_at' => now()->subMinute(),
            'timezone' => 'UTC',
        ]);

        Storage::disk('public')->put($this->mediaPath, 'test video');
        PostMedia::create([
            'scheduled_post_id' => $post->id,
            'media_type' => 'video',
            'file_path' => $this->mediaPath,
            'file_name' => 'test.mp4',
            'mime_type' => 'video/mp4',
            'file_size' => 10,
            'order' => 0,
        ]);

        Http::fake([
            'https://graph.facebook.com/v18.0/me/accounts*' => Http::response([
                'data' => [
                    ['id' => 'first-page', 'access_token' => 'first-page-token'],
                ],
            ]),
            'https://graph.facebook.com/v18.0/first-page/videos' => Http::response([
                'id' => 'published-video-id',
            ]),
        ]);

        (new FacebookPublishJob($post))->handle();

        $post->refresh();
        $this->assertSame('published', $post->status);
        $this->assertSame('published-video-id', $post->platform_post_id);

        Http::assertSent(function ($request) {
            return $request->method() === 'POST'
                && parse_url($request->url(), PHP_URL_PATH) === '/v18.0/first-page/videos';
        });
    }
}
