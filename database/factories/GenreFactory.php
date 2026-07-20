<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Genre>
 */
class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = md5(now());
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text(),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
