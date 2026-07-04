<?php

namespace App\Repositories\Movie;

use App\Http\Requests\MovieStoreRequest;
use App\Models\Movie;

class MovieRepository implements MovieRepositoryInterface
{

    public function store(MovieStoreRequest $movieStoreRequest): Movie
    {
        $validated = $movieStoreRequest->validated();

        $coverPath = null;
        if ($movieStoreRequest->hasFile('cover')) {
            $coverPath = 'storage/' . $movieStoreRequest->file('cover')->store('cover', 'public');
        }

        $newMovie = Movie::query()->create([
            'title' => $validated['title'],
            'genre_id' => $validated['genre_id'],
            'description' => $validated['description'],
            'start_age' => $validated['start_age'],
            'time' => $validated['time'],
            'issue' => $validated['issue'],
            'cover' => $coverPath,
        ]);

        $newMovie->actors()->attach($validated['actors']);

        return $newMovie;
    }
}
