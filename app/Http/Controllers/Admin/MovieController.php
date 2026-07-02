<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        // $movies type = Collection
        $movies = Movie::query()->paginate(20);

        return view('admin.movies.index',
        [
            'movies' => $movies
        ]);
    }

    public function create()
    {
        $actors = Actor::query()
            ->select([
                'id',
                'first_name',
                'last_name',
                'surname'
            ])->get();

        return view('admin.movies.create', [
            'actors' => $actors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        return view('admin.movies.show', [
            'movie' => $movie
        ]);
    }

    public function edit(Movie $movie)
    {
        $actors = Actor::query()->get();

        return view('admin.movies.edit', [
            'movie' => $movie,
            'actors' => $actors
        ]);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
