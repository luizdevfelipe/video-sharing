<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Hashing\HashManager as Hash;

class AuthController extends Controller
{
    public function register(Request $request, Hash $hash)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|bail',
            'email' => 'required|email|max:255|unique:users|bail',
            'password' => 'required|min:8|confirmed|bail'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()], 400);
        }
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hash->make($request->password)
        ]);

        return response()->json(['message' => 'User created successfully'], 201);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|bail',
            'password' => 'required|min:8|bail'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()], 400);
        }

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json(['message' => __('auth.failed')], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('auth_token')->accessToken;
        return response()->json(['token' => $token]);
    }
}
