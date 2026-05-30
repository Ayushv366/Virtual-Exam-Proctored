<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\StudentExam;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentExam>
 */
class StudentExamFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => User::factory()->student(),
            'exam_id' => Exam::factory(),
            'started_at' => now()->subMinutes(20),
            'submitted_at' => now()->subMinutes(5),
            'score' => fake()->numberBetween(40, 95),
            'status' => 'submitted',
            'attempt_data' => ['attempts' => fake()->numberBetween(1, 3)],
        ];
    }
}
