<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model\UserRequest>
 */
class UserRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->optional()->lastName(),
            'last_name' => fake()->lastName(),
            'name_suffix' => fake()->optional()->suffix(),
            'course' => fake()->randomElement(['BSIT', 'BEED', 'BSOA', 'BSED', 'BSHM', 'BTLED', 'BSBA']),
            'level' => fake()->randomElement(['1', '2', '3', '4']),
            'role' => fake()->randomElement(['student', 'alumni']),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
