<?php

namespace App\Repositories\Movie;

use App\Http\Requests\MovieStoreRequest;
use App\Models\Movie;

interface MovieRepositoryInterface
{
    public function store(MovieStoreRequest $movieStoreRequest): Movie;
}
