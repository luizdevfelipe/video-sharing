<?php

namespace Tests\Feature\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VideoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function createVideoRecordWithGetId(): int
    {
        return Video::insertGetId([
            'title' => 'Test Video',
            'description' => 'This is a test video.',
            'video_path' => 'videos/test.mp4',
            'thumbnail_path' => 'thumbnails/test.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function createVideoComment(int $videoId, int $userId): int
    {
        return Comment::insertGetId([
            'video_id' => $videoId,
            'user_id' => $userId,
            'content' => 'This is a test comment.',
        ]);
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

    public function test_can_return_a_video_file(): void
    {
        Storage::fake('local');

        $baseName = 'test';
        $fileName = 'test.m3u8';

        $path = Storage::disk('local')->putFileAs(
            "videos/$baseName",
            UploadedFile::fake()->create($fileName, 1024, 'application/vnd.apple.mpegurl'),
            $fileName
        );

        $fileContent = Storage::disk('local')->get($path);

        $response = $this->get('/api/video/' . $fileName);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.apple.mpegurl');
        $this->assertEquals($fileContent, $response->getContent());
    }

    public function test_can_register_a_comment(): void
    {
        $videoId = $this->createVideoRecordWithGetId();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post("api/video/{$videoId}/comment", [
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
        $videoId = $this->createVideoRecordWithGetId();        

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
        $videoId = $this->createVideoRecordWithGetId();

        $response = $this->get("api/video/{$videoId}/data");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'title',
            'description',
            'video_file',
        ]);
    }
}
