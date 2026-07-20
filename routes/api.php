<?php


use App\Http\Controllers\API\GenreController;

Route::name('api.')->group(function () {
    Route::resource('genres', GenreController::class)
        ->except(['create', 'edit']);
});


