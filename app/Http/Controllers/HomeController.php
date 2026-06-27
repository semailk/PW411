<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function welcome(Request $request): View
    {
        return view('home.welcome');
    }

    public function welcomeSave(Request $request)
    {
        dd($request->input());
    }
}
