<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_refresh_valid_jwt(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAsJwt($user)->post('/api/refresh-token');
        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }

    public function test_refresh_invalid_jwt(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAsJwt($user)->post('/api/refresh-token');

        JWTAuth::invalidate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' .  $this->getJwtToken($user),
        ])->post('/api/refresh-token');

        $response->dump();
        $response->assertStatus(401);
    }
}
