<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Video;

class VideoService
{
    /**
     * Create a new video entry in the database.
     *
     * @param string $title
     * @param string $description
     * @param array $categories
     * @param string $videoPath
     * @param string $thumbnailPath
     * @return void
     */
    public function createVideo(
        string $title,
        string $description,
        array $categories,
        string $videoPath,
        string $thumbnailPath
    ): void {
        $video = Video::create([
            'title' => $title,
            'description' => $description,
            'video_path' => $videoPath,
            'thumbnail_path' => $thumbnailPath,
        ]);

        $categoryIds = array_map(function ($category) {
            $id = Category::where('name', $category)->first()->id;
            if ($id) {
                return $id;
            }
        }, $categories);

        $video->categories()->attach($categoryIds);
    }
}
