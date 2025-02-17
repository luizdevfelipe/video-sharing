<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
});
