<?php

namespace Tests\Unit\Services;

use App\Models\Video;
use App\Services\VideoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoServiceTest extends TestCase
{
    use RefreshDatabase;
    
    private VideoService $videoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->videoService = app(VideoService::class);
    }

    public function test_can_get_video_data_by_file_or_base_name()
    {
        $originalVideo = Video::factory()->create();

        $video = $this->videoService->getVideoByFileOrBaseName($originalVideo->video_path);

        $this->assertNotNull($video);
        $this->assertEquals($originalVideo->title, $video->title);
    }
}