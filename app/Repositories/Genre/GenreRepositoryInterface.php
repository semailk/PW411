<?php

namespace App\Repositories\Genre;

use App\Http\Requests\GenreRequest;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface GenreRepositoryInterface
{
    public function index(): AnonymousResourceCollection;
    public function store(GenreRequest $genreRequest): GenreResource;
    public function show(Genre $genre): GenreResource;
    public function update(GenreRequest $genreRequest, Genre $genre): GenreResource;
    public function destroy(Genre $genre): JsonResponse;
}
