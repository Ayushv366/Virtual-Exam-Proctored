<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Announcement>
 */
class AnnouncementFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'message' => fake()->paragraph(),
            'audience' => fake()->randomElement(['all', 'students', 'faculty']),
            'publish_at' => now(),
            'is_active' => true,
            'created_by' => User::factory()->admin(),
        ];
    }
}
