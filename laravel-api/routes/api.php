<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoController;
use App\Http\Middleware\ControlsVideoAccess;
use Illuminate\Support\Facades\Route;

/**
 * --------------------------------------------------------------------------
 * AUTHENTICATED ROUTES
 * --------------------------------------------------------------------------
 * These routes require authentication.
 * The 'jwt' middleware ensures that the user is authenticated via JWT.
 * The 'verified' middleware ensures that the user has verified their email address.
 */
Route::middleware(['jwt', 'verified'])->group(function () {
    /**
     * --------------------------------------------------------------------------
     * AUTHENTICATED USER ACTIONS
     * --------------------------------------------------------------------------
     * Route group for authenticated user actions
     */
    Route::controller(AuthController::class)->group(function () {
        Route::get('/user', 'getUser')->name('user');
        Route::put('/user', 'updateUser')->name('user.update');
        Route::post('/logout', 'logout')->name('logout');
    });

    /**
     * --------------------------------------------------------------------------
     * PROFILE MANAGEMENT
     * --------------------------------------------------------------------------
     * Route group for profile pages
     */
    Route::controller(ProfileController::class)
        ->prefix('profile')->name('profile.')->group(function () {
            Route::post('/video', 'uploadVideo')->name('video');

            // Route::get('/videos', 'showEditVideos')->name('edit-videos'); TODO
        });

    /**
     * --------------------------------------------------------------------------
     * CATEGORIES AND VIDEO MANAGEMENT
     * --------------------------------------------------------------------------
     * Route group for categories
     */
    Route::get('/categories', [CategoryController::class, 'getCategories'])->name('categories');

    Route::controller(VideoController::class)->prefix('/video')->name('video.')->group(function () {
        Route::post('/{videoId}/comment', 'addComment')->name('.new-comment')->middleware(ControlsVideoAccess::class);
    });
});

/**
 * --------------------------------------------------------------------------
 * PUBLIC ROUTES
 * --------------------------------------------------------------------------
 * These routes are accessible without authentication.
 * They are used for user registration, login, and other public functionalities.
 */
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
});

Route::controller(VideoController::class)->prefix('/video')->name('video')->group(function () {
    Route::get('/', 'getVideosData')->name('.videos')->name('recommend');

    Route::get('/thumb/{fileName}', 'getVideoThumb')->name('.thumbnail');

    Route::middleware(ControlsVideoAccess::class)->group(function () {
        Route::get('/{fileName}', 'getVideoFile')->name('.file');
        Route::get('/{videoId}/comment', 'getComments')->name('.comments');
        Route::get('/{videoId}/data', 'getVideoData')->name('.data');
    });
});
