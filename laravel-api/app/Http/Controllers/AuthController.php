<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    /**
     * Handle user login.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $validate = $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:8|max:60',
            'remember' => 'boolean'
        ]);

        $credentials = ['email' => $validate['email'], 'password' => $validate['password']];

        if (Auth::attempt($credentials, $validate['remember'])) {
            $request->session()->regenerate();
            return response()->json(['message' => __('auth.autenticated')]);
        }

        return response()->json(['message' => __('auth.failed')], 401);
    }

    /**
     * Handle user registration.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request): JsonResponse
    {
        $validate = $request->validate([
            'email' => 'bail|required|email',
            'name' => 'bail|required|min:3|max:60',
            'password' => 'bail|required|min:8|max:60|confirmed',
            'password_confirmation' => 'bail|required|min:8|max:60',
        ]);

        $user = $this->userService->createNewUser($validate);

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();
            return response()->json(['message' => __('auth.registered')]);
        }

        return response()->json(['message' => __('auth.registration-failed')], 400);
    }
}
