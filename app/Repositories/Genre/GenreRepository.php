<?php

namespace App\Repositories\Genre;

use App\Http\Requests\GenreRequest;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GenreRepository implements GenreRepositoryInterface
{
    private const PER_PAGE = 10;
    public function index(): AnonymousResourceCollection
    {
        return GenreResource::collection(Genre::query()->paginate(self::PER_PAGE));
    }

    public function store(GenreRequest $genreRequest): GenreResource
    {
        return GenreResource::make(Genre::query()->create($genreRequest->validated()));
    }

    public function show(Genre $genre): GenreResource
    {
       return GenreResource::make($genre);
    }

    public function update(GenreRequest $genreRequest, Genre $genre): GenreResource
    {
        $genre->update($genreRequest->all());

        return GenreResource::make($genre);
    }

    public function destroy(Genre $genre): JsonResponse
    {
        return response()->json([
            'data' => $genre->delete() ? 'Жанр был удален!' : 'Что-то пошло не так!',
            'status' => $genre->delete() ? 200 : 400
        ]);
    }
}
