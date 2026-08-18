<?php

namespace App\Http\Controllers;

use App\Mail\RegisterWelcomeMail;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        User::query()->get()->map(function (User $user) {
            Mail::to($user)->queue(new RegisterWelcomeMail($user));
        });
        $movies = Movie::query()
            ->with(['genre', 'actors'])
            ->paginate(50);

        return view('home', [
            'movies' => $movies
        ]);
    }

    public function show(Movie $movie): View
    {
        $movie->load([
            'genre:id,name,slug',
            'actors:id,first_name,last_name,surname,photo,biography',
        ]);

        // Похожие фильмы того же жанра
        $relatedMovies = Movie::query()
            ->with(['genre:id,name'])
            ->where('genre_id', $movie->genre_id)
            ->where('id', '!=', $movie->id)
            ->limit(6)
            ->get();

        return view('movies.show', [
            'movie' => $movie,
            'relatedMovies' => $relatedMovies,
        ]);
    }
}
