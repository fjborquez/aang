<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_of_birth' => fake()->dateTime(),
            'is_vegetarian' => fake()->boolean(),
            'is_vegan' => fake()->boolean(),
            'is_celiac' => fake()->boolean(),
            'is_keto' => fake()->boolean(),
            'is_diabetic' => fake()->boolean(),
            'is_lactose' => fake()->boolean(),
            'is_gluten' => fake()->boolean(),
        ];
    }
}
