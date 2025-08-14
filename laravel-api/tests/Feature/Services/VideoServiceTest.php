<?php

namespace Tests\Services\Feature;

use App\Services\VideoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VideoServiceTest extends TestCase
{
    use RefreshDatabase;
    private VideoService $videoService;

    /**
     * Set up the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->videoService = new VideoService();
    }

    /**
     * Test if the VideoService can store video and thumbnail files.
     */
    public function test_if_can_storage_a_video(): void
    {
        // Arrange
        Storage::fake('local');

        $data = [
            'video' => UploadedFile::fake()->create('video.mp4', 2048, 'video/mp4'),
            'thumbnail' => UploadedFile::fake()->image('thumbnail.jpg', 640, 480)->size(1024),
        ];

        // Act
        $filePath = $this->videoService->storageNewUploadedVideoFiles(
            $data['video'],
            $data['thumbnail']
        );
        
        $baseFileName = pathinfo($filePath['video'], PATHINFO_FILENAME);

        // Assert
        $this->assertIsArray($filePath);
        $this->assertArrayHasKey('video', $filePath);
        $this->assertArrayHasKey('thumbnail', $filePath);

        // Verify that the files actually exist in storage
        Storage::assertExists($filePath['video']);
        Storage::assertExists($filePath['thumbnail']);

        // Verify if the converted file was deleted
        $this->assertFalse(file_exists($baseFileName.'/'.$baseFileName."-converted.mp4"));

        // Verify file types (optional but good practice)
        $this->assertStringContainsString('.mp4', $filePath['video']);
        $this->assertStringContainsString('.jpg', $filePath['thumbnail']);
    }

    public function test_if_can_register_new_video_data(): void
    {
        // Arrange
        $data = [
            'title' => 'Test Video',
            'description' => 'This is a test video description.',
            'categories' => ['action', 'drama'],
            'video_path' => 'videos/test_video.mp4',
            'thumbnail_path' => 'thumbnails/test_thumbnail.jpg',
        ];
        // Act
        $videoId = $this->videoService->createVideo(
            $data['title'],
            $data['description'],
            $data['categories'],
            $data['video_path'],
            $data['thumbnail_path']
        );
        // Assert
        $this->assertDatabaseHas('videos', [
            'title' => $data['title'],
            'description' => $data['description'],
            'video_path' => $data['video_path'],
            'thumbnail_path' => $data['thumbnail_path'],
        ]);

        foreach ($data['categories'] as $category) {
            $this->assertDatabaseHas('category_video', [
                'video_id' => $videoId,
                'category_id' => DB::table('categories')->where('name', $category)->where('lang', config('app.locale'))->value('id'),
            ]);
        }
    }
}
