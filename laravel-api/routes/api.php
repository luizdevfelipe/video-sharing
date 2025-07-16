<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Protected routes
 * These routes require authentication.
 * The 'auth:sanctum' middleware ensures that the user is authenticated via Sanctum.
 * The 'verified' middleware ensures that the user has verified their email address.
 */
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    })->withoutMiddleware(['verified'])->name('user');

    /**
     * Route group for profile pages
     */
    Route::controller(ProfileController::class)
        ->prefix('profile')->name('profile.')->group(function () {
            Route::post('/video', 'uploadVideo')->name('video');

            // Route::get('/videos', 'showEditVideos')->name('edit-videos'); TODO
        });
        
    /**
     * Route group for categories
     */
    Route::get('/categories', [CategoryController::class, 'getCategories'])->name('categories');
});

/**
 * Public routes
 * These routes are accessible without authentication.
 * They are used for user registration, login, and other public functionalities.
 */
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
});
