<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostMedia extends Model
{
    protected $fillable = [
        'scheduled_post_id',
        'media_type',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
        'caption',
        'order',
        'platform_media_id',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'order' => 'integer',
    ];

    public function scheduledPost(): BelongsTo
    {
        return $this->belongsTo(ScheduledPost::class);
    }

    public function getFullUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    public function scopeImages($query)
    {
        return $query->where('media_type', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('media_type', 'video');
    }
}
