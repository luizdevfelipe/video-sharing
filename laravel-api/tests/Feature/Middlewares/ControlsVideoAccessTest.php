<?php

namespace Tests\Services\Feature;

use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ControlsVideoAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_the_video_data_is_blocked() 
    {
        Storage::fake('local');

        $baseName = 'test';
        $fileName = 'test0.ts';
        $content = file_get_contents(base_path('tests/Fixtures/test0.ts'));
        Storage::disk('local')->put("videos/$baseName/$fileName", $content);

        $response = $this->get('/api/video/' . $fileName);
        $response->assertStatus(403);
    }
}
