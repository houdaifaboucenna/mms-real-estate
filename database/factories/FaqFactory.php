<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question' => fake()->realText(),
            'question_ar' => fake()->realText(),
            'answer' => fake()->realText(),
            'answer_ar' => fake()->realText(),
            'show_home' => fake()->boolean(),
        ];
    }
}
