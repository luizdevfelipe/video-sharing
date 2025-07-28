<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Video;
use Exception;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;

use function PHPUnit\Framework\directoryExists;
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
        string $videoPath,
        string $thumbnailPath
    ): int {
        $video = Video::create([
            'title' => $title,
            'description' => $description,
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

        return "{$outputBase}.m3u8";
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
