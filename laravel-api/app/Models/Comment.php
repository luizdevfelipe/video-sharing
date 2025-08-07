<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'content'
    ];

    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
}
