<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Exam>
 */
class ExamFactory extends Factory
{
    public function definition(): array
    {
        $startTime = Carbon::now()->addDays(2)->setHour(10)->setMinute(0);

        return [
            'subject_id' => Subject::factory(),
            'faculty_id' => User::factory()->faculty(),
            'title' => fake()->randomElement(['Mid Semester Test', 'Internal Assessment', 'Final Examination']),
            'instructions' => fake()->paragraph(),
            'start_time' => $startTime,
            'end_time' => $startTime->copy()->addHours(2),
            'duration_minutes' => 120,
            'total_marks' => 100,
            'passing_marks' => 40,
            'room_code' => fake()->unique()->bothify('ROOM-####'),
            'is_active' => false,
            'published_at' => null,
        ];
    }
}
