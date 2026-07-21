<?php


use App\Http\Controllers\API\GenreController;
use App\Http\Controllers\API\MovieController;

Route::name('api.')->group(function () {
    // Route::get('api/genres', [GenreController::class, 'index'])->name('api.genres.index');
    Route::resource('genres', GenreController::class)
        ->except(['create', 'edit']);

    Route::resource('movies', MovieController::class)
        ->except(['create', 'edit']);
});


