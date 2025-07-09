<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    /**
     * Route group for profile pages
     */
    Route::controller(ProfileController::class)
        ->prefix('profile')->name('profile.')->group(function () {
            Route::post('/video', 'uploadVideo')->name('video');

            // Route::get('/videos', 'showEditVideos')->name('edit-videos'); TODO
        });

    Route::get('/categories', [CategoryController::class, 'getCategories'])->name('categories');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
});
