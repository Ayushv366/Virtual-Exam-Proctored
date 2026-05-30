<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\ProctorLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProctorLog>
 */
class ProctorLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => User::factory()->student(),
            'exam_id' => Exam::factory(),
            'violation_type' => fake()->randomElement(['tab_switch', 'fullscreen_exit', 'copy_paste', 'idle_timeout', 'right_click']),
            'description' => fake()->sentence(),
            'timestamp' => now(),
        ];
    }
}
