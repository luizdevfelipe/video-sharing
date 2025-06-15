<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/**
 * Route group for home pages
 */
Route::name('home.')->group(function () {
    Route::get('/search', function () {
        return view('home.search');
    })->name('search');
});

/**
 * Route group for Google Authentication
 */
Route::prefix('auth')->name('auth.')->group(function () {
    Route::controller(GoogleAuthController::class)->group(function () {
        Route::get('/google', 'logIn')->name('google');
        Route::get('/google-callback', 'authenticate')->name('authenticate');
    });
});

/**
 * Route group for profile pages
 */
Route::middleware(['auth', 'verified'])->controller(ProfileController::class)
    ->prefix('profile')->name('profile.')->group(function () {
        Route::get('/settings', 'showSettings')->name('settings');
        Route::get('/videos', 'showEditVideos')->name('edit-videos');
        Route::post('/video', 'uploadVideo')->name('video');
    });
