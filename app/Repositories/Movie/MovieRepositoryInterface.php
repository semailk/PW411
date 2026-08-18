<?php

namespace App\Repositories\Movie;

use App\Http\Requests\MovieStoreRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface MovieRepositoryInterface
{
    public function index(): AnonymousResourceCollection;
    public function show(Movie $movie): Movie;
    public function update(Request $request, Movie $movie): Movie;
    public function store(MovieStoreRequest $movieStoreRequest): Movie;
    public function destroy(Movie $movie): JsonResponse;
}
