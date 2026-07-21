<?php

namespace App\Repositories\Movie;

use App\Http\Requests\MovieStoreRequest;
use App\Http\Requests\MovieUpdateRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MovieRepository implements MovieRepositoryInterface
{
    private const PER_PAGE = 10;
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

        return $newMovie->load([
            'genre:id,name',
            'actors:id,first_name,last_name,surname,photo'
        ]);
    }

    public function index(): AnonymousResourceCollection
    {
        $movies = Movie::query()->with([
            'genre:id,name',
            'actors:id,first_name,last_name,surname,photo'
        ])->paginate(self::PER_PAGE);

        return MovieResource::collection($movies);
    }

    public function show(Movie $movie): Movie
    {
        return $movie->load([
            'genre:id,name',
            'actors:id,first_name,last_name,surname,photo'
        ]);
    }

    public function update(MovieUpdateRequest $movieUpdateRequest, Movie $movie): Movie
    {
        // TODO: Implement update() method.
    }

    public function destroy(Movie $movie): JsonResponse
    {
        // TODO: Implement destroy() method.
    }
}
