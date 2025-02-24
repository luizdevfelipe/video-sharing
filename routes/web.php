<?php

use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::controller(GoogleAuthController::class)->group(function () {
    Route::get('/auth/google', 'logIn')->name('auth.google');
    Route::get('/auth/google-callback', 'authenticate')->name('auth.authenticate');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile.profile');
    })->name('profile');
});
