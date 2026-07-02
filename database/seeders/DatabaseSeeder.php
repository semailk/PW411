<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Создаем админа
        User::query()->updateOrCreate(
            ['email' => 'admin@mail.ru'],
            [
                'role' => 'admin',
                'name' => 'Admin',
                'email' => 'admin@mail.ru',
                'password' => Hash::make('adminadmin'),
            ]
        );

        $users = User::factory()->count(20)->create();

        Genre::factory(10)
            ->has(
                Movie::factory()
                    ->count(5)
                    ->has(
                        \App\Models\Actor::factory()->count(5),
                        'actors'
                    )
                    ->afterCreating(function (Movie $movie) use ($users) {
                        // ✅ Используем отношение
                        $movie->comments()->create([
                            'comment' => Str::random(16),
                            'user_id' => $users->random()->id,
                        ]);
                    }),
                'movies'
            )
            ->create()
            ->each(function ($genre) use ($users) {
                $genre->movies->each(function ($movie) use ($users) {
                    $movie->actors->each(function ($actor) use ($users) {
                        // ✅ Используем отношение
                        $actor->comments()->create([
                            'comment' => Str::random(16),
                            'user_id' => $users->random()->id,
                        ]);
                    });
                });
            });
    }
}
