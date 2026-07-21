<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieStoreRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Repositories\Movie\MovieRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MovieController extends Controller
{
    public function __construct(
        private readonly MovieRepository $movieRepository
    ){
    }

    public function index(): AnonymousResourceCollection
    {
        return $this->movieRepository->index();
    }

    public function show(Movie $movie): MovieResource
    {
        return MovieResource::make(
            $this->movieRepository->show($movie)
        );
    }

    public function store(MovieStoreRequest $movieStoreRequest): MovieResource
    {
        return MovieResource::make(
            $this->movieRepository->store($movieStoreRequest)
        );
    }
}
