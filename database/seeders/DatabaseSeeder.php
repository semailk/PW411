<?php

namespace Database\Seeders;

use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(100)->create();

        User::query()->updateOrCreate(
            [
                'email' => 'admin@mail.ru'
            ],[
            'role' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@mail.ru',
            'password' => Hash::make('adminadmin'),
        ]);


        Genre::factory(100)
            ->has(
                Movie::factory()
                    ->count(10)
                ->has(
                    Actor::factory()
                    ->count(5),
                    'actors'
                )
                , 'movies'
            )
            ->create();

//        $this->call([
//            GenreSeeder::class,
//            MovieSeeder::class,
//        ]);
    }
}
