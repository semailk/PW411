<?php

use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/movie/{movie}', [HomeController::class, 'show'])->name('movie.show');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('movies', MovieController::class);
    Route::delete('movies/{movie}/media/{media}', [MovieController::class, 'destroyImage'])->name('movies.destroy-image');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('genres')->name('genres.')->group(function () {
    Route::get('', [GenreController::class, 'index'])->name('index');
    Route::get('create', [GenreController::class, 'create'])->name('create')->middleware(IsAdminMiddleware::class);
    Route::post('', [GenreController::class, 'store'])->name('store')->middleware(IsAdminMiddleware::class);
    Route::put('{genre}', [GenreController::class, 'update'])->name('update')->middleware(IsAdminMiddleware::class);
    Route::get('{genre}', [GenreController::class, 'show'])->name('show');
    Route::get('{genre}/edit', [GenreController::class, 'edit'])->name('edit')->middleware(IsAdminMiddleware::class);
    Route::delete('{genre}', [GenreController::class, 'destroy'])->name('destroy')->middleware(IsAdminMiddleware::class);
});

Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['ru', 'en'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('language.switch');

require __DIR__ . '/auth.php';
