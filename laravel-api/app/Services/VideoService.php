<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Video;
use Exception;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\fileExists;

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
        int $visibility,
        string $videoPath,
        string $thumbnailPath
    ): int {
        $video = Video::create([
            'title' => $title,
            'description' => $description,
            'visibility' => $visibility,
            'video_path' => $videoPath,
            'thumbnail_path' => $thumbnailPath,
        ]);

        $categoryIds = Category::whereIn('name', $categories)
            ->where('lang', config('app.locale'))
            ->pluck('id')
            ->toArray();

        if (!empty($categoryIds)) {
            $video->categories()->attach($categoryIds);
        }

        return $video->id;
    }

    /**
     * Converts a video file to HLS (HTTP Live Streaming) format.
     *
     * This method first transcodes the input video to MP4 using the x264 codec and AAC audio,
     * then generates HLS segments and playlist (.m3u8) using FFmpeg.
     *
     * @param string $inputPath Path to the input video file.
     * @return string Path to the generated .m3u8 playlist file.
     * @throws \RuntimeException If the HLS conversion process fails.
     */
    public function convertToHLS($inputPath): string
    {
        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/bin/ffprobe',
            'timeout'          => 3600,
            'ffmpeg.threads'   => 12,
        ]);

        $video = $ffmpeg->open($inputPath);

        $format = new X264('aac', 'libx264');
        $format->setAudioKiloBitrate(128);
        $format->setKiloBitrate(1000);

        $outputBase = str_replace(['.mp4', '.mov', '.avi', '.wmv'], '', $inputPath);

        $fileName = basename($outputBase);
        
        if (is_dir($outputBase)) {
            throw new Exception('Error during the process: Output directory already exists.');
        }
        
        mkdir($outputBase);
        
        $outputBase = str_replace($fileName, $fileName. '/' .$fileName, $outputBase);

        $video->save($format, $outputBase . "-converted.mp4");

        // Gera HLS usando comandos extras
        $command = [
            '-i',
            "{$outputBase}-converted.mp4",
            '-codec:',
            'copy',
            '-start_number',
            '0',
            '-hls_time',
            '10',
            '-hls_list_size',
            '0',
            '-f',
            'hls',
            "{$outputBase}.m3u8"
        ];

        $process = new \Symfony\Component\Process\Process(array_merge(['/usr/bin/ffmpeg'], $command));
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        if (fileExists($inputPath)) {
            unlink($inputPath);
        }

        if (fileExists("$outputBase-converted.mp4")) {
            unlink("$outputBase-converted.mp4");
        }

        return "{$outputBase}.m3u8";
    }

    /**
     * Store a video file in the local storage.
     *
     * @param $file
     * @return string The path where the video file is stored.
     * @throws \Exception If the storage fails.
     */
    public function storageVideo($file)
    {
        return Storage::disk('local')->putFile('videos', $file);
    }

    /**
     * Store a thumbnail image in the local storage.
     *
     * @param $file
     * @return string The path where the thumbnail image is stored.
     * @throws \Exception If the storage fails.
     */
    public function storageThumbnail($file)
    {
        return Storage::disk('local')->putFile('thumbnails', $file);
    }

    /**
     * Delete a video and its associated categories.
     *
     * @param int $videoId
     * @return bool True if the video was deleted, false otherwise.
     * @throws \Exception If the video does not exist.
     */
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

    /**
     * Get a video by its ID.
     *
     * @param int $videoId
     * @return Video
     * @throws \Exception If the video does not exist.
     */
    public function getVideoById(int $videoId): Video
    {
        return Video::findOrFail($videoId);
    }

    public function getVideoData(int $videoId): Video
    {
        return Video::select('title', 'description', 'video_path')->findOrFail($videoId);
    }
}
