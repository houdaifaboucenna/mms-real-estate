<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->realText(10),
            'title_ar' => fake()->realText(10),
            'content' => fake()->realText(100),
            'content_ar' => fake()->realText(100),
            'short' => fake()->realText(20),
            'short_ar' => fake()->realText(20),
            'image' => fake()->image(),
            'slug' => fake()->slug(),
            'keywords' => fake()->realText(20),
            'keywords_ar' => fake()->realText(20),
            'user_id' => User::factory(),
        ];
    }
}
