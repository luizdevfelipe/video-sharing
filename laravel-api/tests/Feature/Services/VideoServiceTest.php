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
        $filePaths = $this->videoService->storageNewUploadedVideoFiles(
            $data['video'],
            $data['thumbnail']
        );

        // Assert
        $this->assertIsArray($filePaths);
        $this->assertArrayHasKey('video', $filePaths);
        $this->assertArrayHasKey('thumbnail', $filePaths);

        // Verify that files were stored in the correct directories
        $this->assertTrue(str_starts_with($filePaths['video'], 'videos/'));
        $this->assertTrue(str_starts_with($filePaths['thumbnail'], 'thumbnails/'));

        // Verify that the files actually exist in storage
        Storage::assertExists($filePaths['video']);
        Storage::assertExists($filePaths['thumbnail']);

        // Verify file types (optional but good practice)
        $this->assertStringContainsString('.mp4', $filePaths['video']);
        $this->assertStringContainsString('.jpg', $filePaths['thumbnail']);
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
                'category_id' => DB::table('categories')->where('name', $category)->value('id'),
            ]);
        }
    }
}
