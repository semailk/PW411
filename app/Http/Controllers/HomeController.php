<?php

namespace App\Http\Controllers;

use App\Mail\RegisterWelcomeMail;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        User::query()->get()->map(function (User $user) {
            Mail::to($user)->queue(new RegisterWelcomeMail($user));
        });
        $movies = Movie::query()
            ->with(['genre', 'actors'])
            ->paginate(50);

        return view('home', [
            'movies' => $movies
        ]);

    }
}
