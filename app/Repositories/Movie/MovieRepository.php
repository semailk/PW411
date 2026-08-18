<?php

namespace App\Repositories\Movie;

use App\Http\Requests\MovieStoreRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

        // Загрузка изображений через MediaLibrary
        if ($movieStoreRequest->hasFile('images')) {
            foreach ($movieStoreRequest->file('images') as $image) {
                $newMovie->addMedia($image)->toMediaCollection('images');
            }
        }

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

    public function update(Request $request, Movie $movie): Movie
    {
        $validated = $request->validated();

        if ($request->hasFile('cover')) {
            $coverPath = 'storage/' . $request->file('cover')->store('cover', 'public');
            $validated['cover'] = $coverPath;
        }

        $movie->update($validated);

        // Синхронизация актёров
        if (isset($validated['actors'])) {
            $movie->actors()->sync($validated['actors']);
        }

        // Добавление новых изображений через MediaLibrary
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $movie->addMedia($image)->toMediaCollection('images');
            }
        }

        return $movie->load([
            'genre:id,name',
            'actors:id,first_name,last_name,surname,photo'
        ]);
    }

    public function destroy(Movie $movie): JsonResponse
    {
        $movie->clearMediaCollection('images');
        $movie->actors()->detach();
        $movie->delete();

        return response()->json([
            'message' => 'Фильм успешно удалён'
        ]);
    }
}
