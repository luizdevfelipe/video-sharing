<?php

namespace Tests\Services\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\VideoTestSetupTrait;

class ControlsVideoAccessTest extends TestCase
{
    use RefreshDatabase, VideoTestSetupTrait;

    public function test_if_public_binary_file_is_accessible() 
    {
        $testData = $this->setupPublicVideoTest('test0.ts', 'test0');

        $response = $this->get('/api/video/' . $testData['fileName']);
        $response->assertStatus(200);
    }

    public function test_if_the_private_video_file_is_blocked_by_null_user() 
    {
        $testData = $this->setupPrivateVideoTest('test0.ts', 'test0');

        $response = $this->get('/api/video/' . $testData['fileName']);
        $response->assertStatus(403);
    }
}
