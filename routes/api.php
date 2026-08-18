<?php


use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GenreController;
use App\Http\Controllers\API\MovieController;

Route::name('api.')->middleware('auth:api')->group(function () {
    // Route::get('api/genres', [GenreController::class, 'index'])->name('api.genres.index');
    Route::resource('genres', GenreController::class)
        ->except(['create', 'edit']);

    Route::resource('movies', MovieController::class)
        ->except(['create', 'edit']);
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me'])->middleware('auth:api');
});

