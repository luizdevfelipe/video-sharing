<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Video extends Model
{
    protected $fillable = [
        'title',
        'description',
        'visibility',
        'video_path',
        'thumbnail_path',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withTimestamps();;
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
