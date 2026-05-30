<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Computer Networks', 'Database Systems', 'Operating Systems', 'Software Engineering', 'Web Technologies']),
            'code' => fake()->unique()->bothify('SUB-###'),
            'description' => fake()->sentence(12),
            'is_active' => true,
        ];
    }
}
