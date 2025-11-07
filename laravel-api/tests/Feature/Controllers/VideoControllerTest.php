<?php

namespace Tests\Feature\Controllers;

use App\Enums\VideoVisibilityEnum;
use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\Traits\VideoTestSetupTrait;

class VideoControllerTest extends TestCase
{
    use RefreshDatabase, VideoTestSetupTrait;

    public function createVideoComment(int $videoId, int $userId): int
    {
        return Comment::insertGetId([
            'video_id' => $videoId,
            'user_id' => $userId,
            'content' => 'This is a test comment.',
        ]);
    }

    public function videoFileExists($fileName, $baseName, $mimeType): void
    {
        $testData = $this->setupVideoFileTest(
            $fileName, 
            $baseName, 
            'public',
            ['visibility' => VideoVisibilityEnum::PUBLIC]
        );
        
        $fileContent = $testData['content'];
        
        $response = $this->get('/api/video/' . $fileName);
        
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', $mimeType);
        $this->assertEquals($fileContent, $response->getContent());
    }

    public function test_can_return_a_thumbnail_image(): void
    {
        Storage::fake('local');

        $path = Storage::disk('local')->putfile(
            'thumbnails',
            UploadedFile::fake()->image('teste.png', 300, 300,)->size(1024)
        );

        $fileName = str_replace('thumbnails/', '', $path);

        $response = $this->get("api/video/thumb/$fileName");

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/png');
    }
    
    public function test_can_return_a_binary_video_file(): void
    {
        $baseName = 'test0';
        $fileName = 'test0.ts';
        $mimeType = 'video/mp2t';
        
        $this->videoFileExists($fileName, $baseName, $mimeType);
    } 

    public function test_can_return_a_index_video_file(): void
    {
        $baseName = 'test';
        $fileName = 'test.m3u8';
        $mimeType = 'application/vnd.apple.mpegurl';
        
        $this->videoFileExists($fileName, $baseName, $mimeType);
    }

    public function test_can_register_a_comment(): void
    {
        $videoId = Video::factory()->create()->id;

        $user = User::factory()->create();

        $response = $this->actingAsJwt($user)->post("api/video/{$videoId}/comment", [
            'content' => 'This is a test comment.',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => Comment::select('id')->where('user_id', $user->id)->first()->id,
            'user_name' => $user->name,
            'content' => 'This is a test comment.',
        ]);
    }

    public function test_can_get_video_comments(): void
    {
        $user = User::factory()->create();
        $videoId = Video::factory()->create()->id;

        $this->createVideoComment($videoId, $user->id);
        $this->createVideoComment($videoId, $user->id);
        $this->createVideoComment($videoId, $user->id);

        $response = $this->actingAs($user)->get("api/video/{$videoId}/comment");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'user_name',
                    'content',
                ],
            ],
        ]);
    }

    public function test_can_get_video_data(): void
    {
        $videoId = Video::factory()->create()->id;

        $response = $this->get("api/video/{$videoId}/data");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'title',
            'description',
            'video_file',
        ]);
    }

    public function test_if_can_return_video_data_from_query_string() {
        
        $video = Video::factory()->create();

        $response = $this->get("api/video/search?q=" . $video->title);
        $response->assertStatus(200);
    }
}
