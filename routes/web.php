<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'welcome'])->name('home');

Route::post('', [HomeController::class, 'welcomeSave'])->name('home.save');

//Route::get();
//Route::post();
