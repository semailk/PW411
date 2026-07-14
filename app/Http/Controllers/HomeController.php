<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $movies = Movie::query()
            ->with(['genre', 'actors'])
            ->paginate(50);

        return view('home', [
            'movies' => $movies
        ]);
    }

//    public function index(Request $request): View
//    {
//        $page = $request->page ?? 1;
//
//        // home.index.2
//        if (Cache::has('home.index.' . $page)) {
//            return view('home', [
//                'movies' => Cache::get('home.index.' . $page),
//            ]);
//        }
//        $movies = Movie::query()->with([
//            'genre'
//        ])->get()->toArray();
//        Cache::put('home.index.' . $page, $movies);
//
//        return view('home', [
//            'movies' => Cache::get('home.index.' . $page),
//        ]);
//    }
}
