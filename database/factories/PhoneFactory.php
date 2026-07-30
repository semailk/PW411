<?php

namespace Database\Factories;

use App\Models\Phone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Phone>
 */
class PhoneFactory extends Factory
{
    public function definition(): array
    {
        return [
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}
