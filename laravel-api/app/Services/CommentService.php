<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentService
{

    /**
     * Get all comments for a specific video.
     *
     * @param int $videoId
     * @return array
     */
    public function getComments(int $videoId): array
    {
        return Comment::select(['c.id', 'u.name as user_name', 'c.content'])
            ->from('comments as c')
            ->join('users as u', 'c.user_id', '=', 'u.id')
            ->where('c.video_id', $videoId)
            ->get()->toArray();
    }
}
