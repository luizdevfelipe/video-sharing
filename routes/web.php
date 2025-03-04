<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/**
 * Route group for home pages
 */
Route::name('home.')->group(function () {
    Route::get('/', function () {
        return view('home.index');
    })->name('index');

    Route::get('/search', function () {
        return view('home.search');
    })->name('search');
});

/**
 * Route group for Google Authentication
 */
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::controller(GoogleAuthController::class)->group(function () {
        Route::get('/google', 'logIn')->name('google');
        Route::get('/google-callback', 'authenticate')->name('authenticate');
    });
});

/**
 * Route group for profile pages
 */
Route::middleware(['auth'])->controller(ProfileController::class)
    ->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/video', 'uploadVideo')->name('video');
    });
