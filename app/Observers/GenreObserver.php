<?php

namespace App\Observers;

use App\Models\Genre;
use Illuminate\Support\Facades\Cache;

class GenreObserver
{
    public function created(Genre $genre): void
    {
        $this->cacheCreated($genre);
    }

    public function updated(Genre $genre): void
    {
        $this->cacheCreated($genre);
    }

    public function deleted(Genre $genre): void
    {
        $this->cacheCreated($genre, true);
    }

    private function cacheCreated(Genre $genre, bool $deleted = false): void
    {
        if ($deleted) {
            Cache::forget('genres_' . $genre->id);
        }else{
            Cache::put('genres_' . $genre->id, $genre->toArray(), 60 * 24 * 30);
        }

        Cache::put('genres', Genre::all()->toArray(), 60 * 24 * 30);
    }
}
