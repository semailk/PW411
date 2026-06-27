<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        User::query()->updateOrCreate(
            [
                'email' => 'admin@mail.ru'
            ],[
            'role' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@mail.ru',
            'password' => Hash::make('adminadmin'),
        ]);

        $this->call([
            GenreSeeder::class,
        ]);
    }
}
