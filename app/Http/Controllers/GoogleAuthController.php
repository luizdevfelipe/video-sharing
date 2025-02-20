<?php

namespace App\Http\Controllers;

use App\Models\User;
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
    public function logIn(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Function that authenticates the user through Google Account.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->id)->first();

        if ($user) {
            Auth::login($user);
            return redirect()->route('home');
        } else {
            $createdUser = User::create([
                'name'      => $googleUser->name,
                'email'     => $googleUser->email,
                'password'  => Hash::make(bin2hex(random_bytes(24)) . time()),
                'google_id' => $googleUser->id,
            ]);

            if ($createdUser) {
                Auth::login($createdUser);
                return redirect()->route('home');
            }
        }
    }
}
