<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CityTown>
 */
class CityTownFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'name_ar' => fake()->name(),
            'slug' => fake()->slug(),
            'city_id' => City::factory(),
        ];
    }
}
