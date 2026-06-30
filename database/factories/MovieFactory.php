<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Movie>
 */
class MovieFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->title(),
            'description' => $this->faker->text(100),
            'start_age' => rand(6, 21) . '+',
            'issue' => $this->faker->year(),
            'time' => rand(60, 150),
        ];
    }
}
