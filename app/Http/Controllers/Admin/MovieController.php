<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieStoreRequest;
use App\Http\Requests\MovieUpdateRequest;
use App\Models\Actor;
use App\Models\Movie;
use App\Repositories\Movie\MovieRepository;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MovieController extends Controller
{
    public function __construct(
        private MovieRepository $movieRepository,
    )
    {
    }

    public function index()
    {
        $movies = Movie::query()->paginate(20);

        return view('admin.movies.index', [
            'movies' => $movies
        ]);
    }

    public function create()
    {
        $actors = Actor::query()
            ->select([
                'id',
                'first_name',
                'last_name',
                'surname'
            ])->get();

        $genres = \App\Models\Genre::all();

        return view('admin.movies.create', [
            'actors' => $actors,
            'genres' => $genres,
        ]);
    }

    public function store(MovieStoreRequest $movieStoreRequest)
    {
        return redirect()->route('admin.movies.show',
            $this->movieRepository->store($movieStoreRequest)
        );
    }

    public function show(Movie $movie)
    {
        $movie->loadMedia('images');

        return view('admin.movies.show', [
            'movie' => $movie
        ]);
    }

    public function edit(Movie $movie)
    {
        $actors = Actor::query()->get();
        $genres = \App\Models\Genre::all();

        return view('admin.movies.edit', [
            'movie' => $movie,
            'actors' => $actors,
            'genres' => $genres,
        ]);
    }

    public function update(MovieUpdateRequest $request, Movie $movie)
    {
        $this->movieRepository->update($request, $movie);

        return redirect()->route('admin.movies.show', $movie);
    }

    public function destroy(Movie $movie)
    {
        $this->movieRepository->destroy($movie);

        return redirect()->route('admin.movies.index');
    }

    /**
     * Удаление одного изображения из медиа-коллекции.
     */
    public function destroyImage(Movie $movie, $media): RedirectResponse
    {
        $movie->clearMediaCollectionItem('images', $media);

        return redirect()->route('admin.movies.edit', $movie)
            ->with('success', 'Изображение удалено');
    }
}
