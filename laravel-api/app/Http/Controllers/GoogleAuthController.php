<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Function that authenticates the user through Google Account.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(): JsonResponse
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->id)->first();

        if (!$user) {
            $user = User::create([
                'name'      => $googleUser->name,
                'email'     => $googleUser->email,
                'password'  => Hash::make(bin2hex(random_bytes(24)) . time()),
                'google_id' => $googleUser->id,
            ]);
        }

        Auth::login($user);

        return response()->json(['message' => 'Autenticated']);
    }
}
