<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenreRequest;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use App\Repositories\Genre\GenreRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GenreController extends Controller
{
    public function __construct(
        private GenreRepository $genreRepository
    ){}

    public function index(): AnonymousResourceCollection
    {
        return $this->genreRepository->index();
    }

    public function show(Genre $genre): GenreResource
    {
        return $this->genreRepository->show($genre);
    }

    public function store(GenreRequest $genreRequest): GenreResource
    {
        return $this->genreRepository->store($genreRequest);
    }

    public function update(GenreRequest $genreRequest, Genre $genre): GenreResource
    {
        return $this->genreRepository->update($genreRequest, $genre);
    }

    public function destroy(Genre $genre): JsonResponse
    {
        return $this->genreRepository->destroy($genre);
    }
}
