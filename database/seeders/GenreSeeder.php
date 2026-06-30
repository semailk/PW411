<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
//        $genres = [
//            // Основные жанры
//            ['name' => 'Боевик', 'slug' => 'boevik', 'description' => 'Динамичные фильмы с перестрелками и погонями'],
//            ['name' => 'Комедия', 'slug' => 'komediya', 'description' => 'Фильмы, поднимающие настроение'],
//            ['name' => 'Драма', 'slug' => 'drama', 'description' => 'Серьёзные фильмы с глубоким сюжетом'],
//            ['name' => 'Мелодрама', 'slug' => 'melodrama', 'description' => 'Фильмы о любви и чувствах'],
//            ['name' => 'Триллер', 'slug' => 'triller', 'description' => 'Напряжённые фильмы с неожиданными поворотами'],
//            ['name' => 'Ужасы', 'slug' => 'uzhasy', 'description' => 'Страшные и пугающие фильмы'],
//            ['name' => 'Фантастика', 'slug' => 'fantastika', 'description' => 'Фильмы о будущем и технологиях'],
//            ['name' => 'Фэнтези', 'slug' => 'fentezi', 'description' => 'Волшебные и магические истории'],
//            ['name' => 'Приключения', 'slug' => 'priklyucheniya', 'description' => 'Путешествия и захватывающие истории'],
//            ['name' => 'Детектив', 'slug' => 'detektiv', 'description' => 'Расследования и загадки'],
//
//            // Дополнительные жанры
//            ['name' => 'Криминал', 'slug' => 'kriminal', 'description' => 'Фильмы о преступном мире'],
//            ['name' => 'Вестерн', 'slug' => 'vestern', 'description' => 'Фильмы о Диком Западе'],
//            ['name' => 'Исторический', 'slug' => 'istoricheskiy', 'description' => 'Фильмы о прошлых эпохах'],
//            ['name' => 'Военный', 'slug' => 'voennyy', 'description' => 'Фильмы о войне и армии'],
//            ['name' => 'Биографический', 'slug' => 'biograficheskiy', 'description' => 'Фильмы о реальных людях'],
//            ['name' => 'Спортивный', 'slug' => 'sportivnyy', 'description' => 'Фильмы о спорте'],
//            ['name' => 'Музыкальный', 'slug' => 'muzykalnyy', 'description' => 'Фильмы с музыкальными номерами'],
//            ['name' => 'Мюзикл', 'slug' => 'myuzikl', 'description' => 'Музыкальные фильмы с танцами'],
//            ['name' => 'Нуар', 'slug' => 'noir', 'description' => 'Тёмные детективные фильмы'],
//            ['name' => 'Артхаус', 'slug' => 'arthaus', 'description' => 'Авторские и экспериментальные фильмы'],
//        ];
//
//        foreach ($genres as $genre) {
//            Genre::query()->updateOrInsert(
//                ['slug' => $genre['slug']],
//                [
//                    'name' => $genre['name'],
//                    'description' => $genre['description'],
//                    'created_at' => now(),
//                    'updated_at' => now(),
//                ]
//            );
//        }
    }
}
