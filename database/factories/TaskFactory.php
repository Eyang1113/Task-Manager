<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'due_date' =>fake()->dateTimeBetween('now', '+1 month'),
            'status' => fake()->randomElement(array_keys(Task::STATUS_OPTIONS)),
            'priority' => fake()->randomElement(array_keys(Task::PRIORITY_OPTIONS)),
        ];
    }
}
