<?php

namespace Tests\Traits;

use App\Helpers\VideoPathHelper;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;

trait VideoTestSetupTrait 
{
    /**
     * Setup a video file test with storage fake and video creation
     *
     * @param string $fileName The name of the fixture file (e.g., 'test0.ts')
     * @param string|null $baseName The base name for video_path (defaults to filename without extension)
     * @param string $visibility The visibility of the video ('private' or 'public')
     * @param array $videoAttributes Additional attributes for the video factory
     * @return array Returns an array with video, fileName, content, filePath, and baseName
     */
    protected function setupVideoFileTest(
        string $fileName, 
        string $baseName = null, 
        string $visibility = 'private',
        array $videoAttributes = []
    ): array {
        Storage::fake('local');
        
        $baseName = $baseName ?? pathinfo($fileName, PATHINFO_FILENAME);
        $fixturePath = base_path("tests/Fixtures/{$fileName}");
        
        if (!file_exists($fixturePath)) {
            throw new \Exception("Fixture file not found: {$fixturePath}");
        }
        
        $content = file_get_contents($fixturePath);
        $filePath = VideoPathHelper::generateVideoFileLocalPath($fileName);
        
        $defaultAttributes = [
            'video_path' => $baseName,
        ];
        
        // Create video with appropriate visibility
        $factory = Video::factory();
        if ($visibility === 'private') {
            $factory = $factory->private();
        }
        // For public videos, use the default state (which is already public)
        
        $video = $factory->create(array_merge($defaultAttributes, $videoAttributes));
        
        Storage::disk('local')->put($filePath, $content);
        
        return [
            'video' => $video,
            'fileName' => $fileName,
            'content' => $content,
            'filePath' => $filePath,
            'baseName' => $baseName
        ];
    }

    /**
     * Setup a private video file test (shorthand method)
     *
     * @param string $fileName The name of the fixture file
     * @param array $videoAttributes Additional attributes for the video factory
     * @return array
     */
    protected function setupPrivateVideoTest(string $fileName = 'test0.ts', array $videoAttributes = []): array
    {
        return $this->setupVideoFileTest($fileName, null, 'private', $videoAttributes);
    }

    /**
     * Setup a public video file test (shorthand method)
     *
     * @param string $fileName The name of the fixture file
     * @param array $videoAttributes Additional attributes for the video factory
     * @return array
     */
    protected function setupPublicVideoTest(string $fileName = 'test0.ts', array $videoAttributes = []): array
    {
        return $this->setupVideoFileTest($fileName, null, 'public', $videoAttributes);
    }
}