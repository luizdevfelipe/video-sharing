<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(private UserService $userService) {}

    /**
     * Handle user registration.
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = $this->userService->createNewUser($validated);

        if (!$user) {
            return response()->json(['message' => __('auth.registration-failed')], 400);
        }

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Could not create token'], 500);
        }

        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => __('auth.registered')
        ], 201);
    }

    /**
     * Handle user login and return a JWT token.
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => __('auth.failed')], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 401);
        }

        return response()->json(['token' => $token]);
    }

    /**
     * Handle user logout by invalidating the JWT token.
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Fetch the authenticated user's profile.
     * @return JsonResponse
     */
    public function getUser(): JsonResponse
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            return response()->json($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to fetch user profile'], 401);
        }
    }

    /**
     * Update the authenticated user's profile.
     * @param Request $request
     * @return JsonResponse
     */
    public function updateUser(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $user->update($request->only(['name', 'email']));
            return response()->json($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to update user'], 401);
        }
    }

    /**
     * Refresh the JWT token.
     * @return JsonResponse
     */
    public function refreshToken(): JsonResponse
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());
            return response()->json(['token' => $newToken]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to refresh token'], 401);
        }
    }
}
