<?php

namespace Database\Factories;

use App\Models\Office;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $studentIds = User::whereIn('role', ['student', 'alumni'])->pluck('id')->toArray();
        $officeIds = Office::pluck('id')->toArray();

        return [
            'sender_id' => fake()->randomElement($studentIds),
            'assigned_to' => fake()->randomElement($officeIds),
            'level' => fake()->randomElement(['normal', 'important', 'critical']),
            'subject' => fake()->sentence(),
            'category' => fake()->word(),
            'content' => fake()->paragraph(),
            'status' => fake()->randomElement(['new', 'pending', 'resolved', 'closed']),
        ];
    }
}
