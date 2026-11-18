<?php

use App\Http\Controllers\OpenLibraryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

Route::prefix('v1')->group(function () {

    // =========================
    // ENDPOINT PUBLIK
    // =========================

    Route::get('/open-library', OpenLibraryController::class);

    Route::get('/books', [BookController::class, 'index']);

    Route::get('/books/{book}', [BookController::class, 'show']);

    Route::get('/stats', [BookController::class, 'stats']);


    // =========================
    // AUTENTIKASI
    // =========================

    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/auth/me', [AuthController::class, 'me']);

        Route::post('/auth/logout', [AuthController::class, 'logout']);


        // =========================
        // KHUSUS PENGELOLA
        // =========================

        Route::middleware([
            'abilities:books:write',
            'admin',
        ])->group(function () {

            Route::post('/books', [BookController::class, 'store']);

            Route::patch('/books/{book}', [BookController::class, 'update']);

            Route::delete('/books/{book}', [BookController::class, 'destroy']);

        });

    });

});
