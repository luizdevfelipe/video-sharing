<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::middleware(['auth:api', 'throttle:login'])->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
});
