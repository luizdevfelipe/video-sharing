<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    /**
     *  Authenticate the given user via JWT for testing purposes.
     */
    protected function actingAsJwt(User $user): TestCase
    {
        $token = $this->getJwtToken($user);
        return $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);
    }

    /**
     * Generate a JWT token for the given user.
     */
    protected function getJwtToken(User $user): string
    {
        return JWTAuth::fromUser($user);
    }
}
