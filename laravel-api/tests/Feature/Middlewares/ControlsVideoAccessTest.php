<?php

namespace Tests\Services\Feature;

use App\Models\User;
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

    public function test_if_private_video_file_is_accessed_by_valid_user()
    {
        $user = User::factory()->create();

        $testData = $this->setupPrivateVideoTest('test0.ts', 'test0');

        $user->videos()->attach($testData['video']->id, [
            'permission' => now()
        ]);

        $response = $this->actingAsJwt($user)->get('/api/video/' . $testData['fileName']);
        
        $response->assertStatus(200);
    }
}
