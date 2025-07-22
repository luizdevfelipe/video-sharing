<?php

namespace Tests\Feature\Controllers;

use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VideoControllerTest extends TestCase
{
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
}
