<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $movies = Movie::query()->paginate(12);

        return view('home', [
            'movies' => $movies
        ]);
    }
}
