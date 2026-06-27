<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();

        return view('admin.genres.index', [
            'genres' => $genres
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
            'is_active' => (boolean) $request->is_active,
        ]);

        return redirect()->route('genres.show', $genre->slug);
    }

    public function show(string $slug)
    {
        return view('admin.genres.show', [
            'genre' => Genre::query()->where('slug', $slug)->firstOrFail()
        ]);
    }

    public function edit(string $slug)
    {
        return view('admin.genres.edit', [
            'genre' => Genre::query()->where('slug', $slug)->firstOrFail()
        ]);
    }

    public function update(Request $request, Genre $genre)
    {
        $genre->update([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
            'is_active' => (boolean) $request->is_active,
        ]);

        return redirect()->route('genres.show', $genre->slug);
    }

    public function destroy(string $id)
    {
        //
    }
}
