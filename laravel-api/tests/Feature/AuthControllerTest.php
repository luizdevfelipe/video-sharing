<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Providers\Auth\Illuminate;

class AuthControllerTest extends TestCase
{
    public function test_refresh_valid_jwt(): void
    {
        $user = User::factory()->create();

        $token = $this->getJwtToken($user);

        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->post('/api/refresh-token');

        $response->dump();

        $response->assertStatus(200);
    }

