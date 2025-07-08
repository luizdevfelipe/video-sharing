<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_upload_video_route(): void
    {
        // Arrange
        Storage::fake('local');

        $user = User::factory()->create();
        
        // Act
        $response = $this->actingAs($user)->post('/api/profile/video', [
            'title' => 'Sample Video Title',
            'description' => 'This is a sample video description that is long enough to meet the validation requirements for the test.',
            'categories' => ['action', 'drama'],
            'video' => UploadedFile::fake()->create('video.mp4', 2048, 'video/mp4'),
            'thumbnail' => UploadedFile::fake()->image('thumbnail.jpg', 640, 480)->size(1024),
        ]);

        // Assert
        $response->assertStatus(200);
    }
}
