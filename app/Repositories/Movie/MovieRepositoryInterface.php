<?php

namespace App\Repositories\Movie;

use App\Http\Requests\MovieStoreRequest;
use App\Http\Requests\MovieUpdateRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface MovieRepositoryInterface
{
    public function index(): AnonymousResourceCollection;
    public function show(Movie $movie): Movie;
    public function update(MovieUpdateRequest $movieUpdateRequest, Movie $movie): Movie;
    public function store(MovieStoreRequest $movieStoreRequest): Movie;
    public function destroy(Movie $movie): JsonResponse;
}
