<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
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
     * Function that authenticates the usar through Google Account.
     * @return void
     */
    public function authenticate(): void
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->id)->first();

        dd($user);
    }
}
