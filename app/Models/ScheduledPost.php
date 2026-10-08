<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduledPost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'platform',
        'social_account_id',
        'content',
        'status',
        'scheduled_at',
        'published_at',
        'timezone',
        'platform_post_id',
        'api_response',
        'error_message',
        'retry_count',
        'max_retries',
        'next_retry_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'published_at' => 'datetime',
        'next_retry_at' => 'datetime',
        'api_response' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function socialAccount(): BelongsTo
    {
        return $this->belongsTo(SocialAccount::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(PostMedia::class)->orderBy('order');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeForPlatform($query, $platform)
    {
        return $query->where('platform', $platform);
    }

    public function scopeDueForPublishing($query)
    {
        return $query->whereIn('status', ['pending', 'scheduled'])
            ->where('scheduled_at', '<=', now())
            ->where(function ($q) {
                $q->whereNull('next_retry_at')
                    ->orWhere('next_retry_at', '<=', now());
            });
    }

    public function canRetry(): bool
    {
        return $this->retry_count < $this->max_retries;
    }

    public function incrementRetry(): void
    {
        $this->retry_count++;
        
        if ($this->canRetry()) {
            // Exponential backoff: 2^retry_count minutes
            $delayMinutes = pow(2, $this->retry_count);
            $this->next_retry_at = now()->addMinutes($delayMinutes);
        } else {
            $this->next_retry_at = null;
        }
        
        $this->save();
    }

    public function markAsPublished(string $platformPostId, array $apiResponse): void
    {
        $this->update([
            'status' => 'published',
            'published_at' => now(),
            'platform_post_id' => $platformPostId,
            'api_response' => $apiResponse,
            'error_message' => null,
            'next_retry_at' => null,
        ]);
    }

    public function markAsFailed(string $errorMessage): void
    {
        $this->incrementRetry();
        
        $this->update([
            'status' => $this->canRetry() ? 'pending' : 'failed',
            'error_message' => $errorMessage,
        ]);
    }

    public function cancel(): void
    {
        $this->update([
            'status' => 'cancelled',
            'next_retry_at' => null,
        ]);
    }
}
