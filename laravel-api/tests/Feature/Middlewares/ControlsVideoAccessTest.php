<?php

namespace Tests\Services\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\VideoTestSetupTrait;

class ControlsVideoAccessTest extends TestCase
{
    use RefreshDatabase, VideoTestSetupTrait;

    public function test_if_the_video_file_is_blocked_by_null_user() 
    {
        $testData = $this->setupPrivateVideoTest('test0.ts');

        $response = $this->get('/api/video/' . $testData['fileName']);
        $response->assertStatus(403);
    }
}
