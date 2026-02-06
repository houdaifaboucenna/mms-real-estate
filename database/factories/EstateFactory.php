<?php

namespace Database\Factories;

use App\Enums\EstateTypeEnum;
use App\Models\CityTown;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estate>
 */
class EstateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'content' => fake()->text(),
            'title_ar' => fake()->name(),
            'content_ar' => fake()->text(),
            'short' => fake()->text(),
            'short_ar' => fake()->text(),
            'keywords' => fake()->text(),
            'keywords_ar' => fake()->text(),
            'slug' => fake()->slug(),
            'town_id' => CityTown::factory(),
            'image' => fake()->image(),
            'type' => fake()->randomElement(EstateTypeEnum::cases()),
            'min' => fake()->randomFloat(2, 1000, 10000),
            'max' => fake()->randomFloat(2, 1000, 10000),
        ];
    }
}
