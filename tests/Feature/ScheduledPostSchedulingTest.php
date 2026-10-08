<?php

namespace Tests\Feature;

use App\Models\ScheduledPost;
use App\Models\SocialAccount;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduledPostSchedulingTest extends TestCase
{
    use RefreshDatabase;

    public function test_future_datetime_is_validated_and_saved_in_the_selected_timezone(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-10-08 10:00:00', 'UTC'));

        try {
            $user = User::factory()->create();
            $socialAccount = SocialAccount::create([
                'user_id' => $user->id,
                'platform' => 'facebook',
                'account_name' => 'Test Page',
                'status' => 'connected',
            ]);

            $this->actingAs($user)
                ->post(route('posts.store'), [
                    'platform' => 'facebook',
                    'social_account_id' => $socialAccount->id,
                    'content' => 'Timezone-aware future post',
                    'scheduled_date' => '2026-10-08T04:30',
                    'timezone' => 'America/Los_Angeles',
                ])
                ->assertRedirect(route('posts.index'));

            $post = ScheduledPost::query()->firstOrFail();

            $this->assertSame('scheduled', $post->status);
            $this->assertSame('2026-10-08 11:30:00', $post->scheduled_at->format('Y-m-d H:i:s'));
            $this->assertSame('America/Los_Angeles', $post->timezone);
            $this->assertSame($user->id, $post->user_id);
            $this->assertSame($socialAccount->id, $post->social_account_id);

            $post->update(['status' => 'pending']);

            $this->actingAs($user)
                ->get(route('posts.index'))
                ->assertOk()
                ->assertSee('Timezone-aware future post')
                ->assertSee('Pending')
                ->assertSee('Oct 08, 2026 - 4:30 AM')
                ->assertSee('America/Los_Angeles');
        } finally {
            Carbon::setTestNow();
        }
    }

    public function test_past_datetime_in_selected_timezone_is_rejected(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-10-08 10:00:00', 'UTC'));

        try {
            $user = User::factory()->create();
            $socialAccount = SocialAccount::create([
                'user_id' => $user->id,
                'platform' => 'facebook',
                'account_name' => 'Test Page',
                'status' => 'connected',
            ]);

            $this->actingAs($user)
                ->from(route('posts.create'))
                ->post(route('posts.store'), [
                    'platform' => 'facebook',
                    'social_account_id' => $socialAccount->id,
                    'content' => 'Past local time',
                    'scheduled_date' => '2026-10-08T14:30',
                    'timezone' => 'Asia/Karachi',
                ])
                ->assertRedirect(route('posts.create'))
                ->assertSessionHasErrors('scheduled_date');

            $this->assertDatabaseMissing('scheduled_posts', [
                'user_id' => $user->id,
                'content' => 'Past local time',
            ]);
        } finally {
            Carbon::setTestNow();
        }
    }
}
