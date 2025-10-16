<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    /**
     *  Authenticate the given user via JWT for testing purposes.
     */
    protected function actingAsJwt(User $user): TestCase
    {
        $token = $this->attemptAuth($user);
        return $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);
    }

    /**
     * Authenticate and generate a JWT token for the given user.
     */
    protected function attemptAuth(User $user): string
    {
        try {
            return JWTAuth::attempt(['email' => $user->email, 'password' => 'password']);
        } catch (JWTException $e) {
            $this->fail('Could not authenticate user and create token: ' . $e->getMessage());
        }
    }

    /**
     * Get a JWT token for the given user.
     */
    protected function getJwtToken(User $user): string
    {
        return JWTAuth::fromUser($user);
    }
}
