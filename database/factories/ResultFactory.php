<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\Result;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Result>
 */
class ResultFactory extends Factory
{
    public function definition(): array
    {
        $obtainedMarks = fake()->numberBetween(35, 95);
        $totalMarks = 100;

        return [
            'student_id' => User::factory()->student(),
            'exam_id' => Exam::factory(),
            'obtained_marks' => $obtainedMarks,
            'total_marks' => $totalMarks,
            'percentage' => round(($obtainedMarks / $totalMarks) * 100, 2),
            'status' => $obtainedMarks >= 40 ? 'passed' : 'failed',
            'remarks' => fake()->sentence(),
            'published_at' => now(),
        ];
    }
}
