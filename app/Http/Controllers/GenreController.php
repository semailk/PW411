<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class GenreController extends Controller
{
    public function index()
    {
        if (Cache::has('genres')) {
            $genres = Cache::get('genres');
        }else{
            $genres = Genre::all();
            Cache::put('genres', $genres->toArray(), 60 * 24 * 30);
        }

        return view('admin.genres.index', [
            'allGenres' => collect($genres)
        ]);
    }

    public function create()
    {
        return view('admin.genres.create');
    }

    public function store(Request $request)
    {
        $genre = Genre::query()->create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
            'is_active' => (boolean)$request->is_active,
        ]);

        return redirect()->route('genres.show', $genre->slug);
    }

    public function show(Genre $genre)
    {
        if (Cache::has('genres_' . $genre->id)) {
            $genre = Cache::get('genres_' . $genre->id);
        } else {
            Cache::put('genres_' . $genre->id, $genre->toArray(), 60 * 24 * 30);
        }

        return view('admin.genres.show', [
            'genre' => (object)$genre
        ]);
    }

    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', [
            'genre' => empty(Cache::get('genres_' . $genre->id)) ?
                $genre :
                (object) Cache::get('genres_' . $genre->id)
        ]);
    }

    public function update(Genre $genre, Request $request)
    {
        $genre->update([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
            'is_active' => (boolean)$request->is_active,
        ]);

        return redirect()->route('genres.show', $genre->id);
    }

    public function destroy(string $slug)
    {
        $genre = Genre::query()->where('slug', $slug)->firstOrFail();

        $genre->movies->map(function (Movie $movie) {
            $movie->actors()->detach();
            $movie->forceDelete();
        });

        $genre->delete();

        return redirect()->route('genres.index');
    }
}
