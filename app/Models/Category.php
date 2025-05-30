<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    public function videos(): BelongsToMany
    {
        return $this->belongsToMany(Video::class)->withTimestamps();;
    }
}
