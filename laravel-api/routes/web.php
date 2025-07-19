<?php

use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Route;

/**
 * Route group for Google Authentication
 */
Route::prefix('auth')->name('auth.')->group(function () {
    Route::controller(GoogleAuthController::class)->group(function () {
        Route::get('/google', 'logIn')->name('google');
        Route::get('/google-callback', 'authenticate')->name('authenticate');
    });
});
