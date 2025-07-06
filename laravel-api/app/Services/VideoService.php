<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;

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
     * @return int $videoId
     */
    public function createVideo(
        string $title,
        string $description,
        array $categories,
        string $videoPath,
        string $thumbnailPath
    ): int {
        $video = Video::create([
            'title' => $title,
            'description' => $description,
            'video_path' => $videoPath,
            'thumbnail_path' => $thumbnailPath,
        ]);

        $categoryIds = [];
        foreach ($categories as $name) {
            $category = Category::select('id')->where('name', $name)->first();
            if ($category) {
                $categoryIds[] = $category->id;
            }
        }

        if (!empty($categoryIds)) {
            $video->categories()->attach($categoryIds);
        }

        return $video->id;
    }

    public function storageVideo($file)
    {
        return Storage::disk('local')->putFile('videos', $file);
    }

    public function storageThumbnail($file)
    {
        return Storage::disk('local')->putFile('thumbnails', $file);
    }

    public function deleteVideo(int $videoId): bool
    {
        $video = Video::find($videoId);
        if (!$video) {
            return false;
        }
        $video->delete();
        $video->categories()->detach();

        return (bool) $video;
    }

    /**
     * Store new uploaded video and thumbnail files.
     *
     * @param $video
     * @param $thumbnail
     * @return array {
     *     video: string,
     *     thumbnail: string
     * }
     */
    public function storageNewUploadedVideoFiles($video, $thumbnail): array
    {
        $videoPath = $this->storageVideo($video);
        $thumbnailPath = $this->storageThumbnail($thumbnail);

        return [
            'video' => $videoPath,
            'thumbnail' => $thumbnailPath
        ];
    }
}
