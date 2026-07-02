<?php

namespace App\Providers;

use App\Models\Genre;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $genres = collect();

        if(Schema::hasTable('genres')) {
            $genres = Genre::query()->where('is_active', true)->get();
        }

        View::composer('*', function ($view) use ($genres) {
            $view->with('genres', $genres);
        });
    }
}
