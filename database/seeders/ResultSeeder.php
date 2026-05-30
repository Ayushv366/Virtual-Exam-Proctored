<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Result;
use App\Models\User;
use Illuminate\Database\Seeder;

class ResultSeeder extends Seeder
{
    public function run(): void
    {
        $exams = Exam::query()->get();
        $students = User::query()->where('role', 'student')->get();

        foreach ($students->take(5) as $index => $student) {
            $exam = $exams[$index % max(1, $exams->count())];
            $obtainedMarks = 55 + ($index * 5);

            Result::updateOrCreate(
                ['student_id' => $student->id, 'exam_id' => $exam->id],
                [
                    'obtained_marks' => $obtainedMarks,
                    'total_marks' => 100,
                    'percentage' => $obtainedMarks,
                    'status' => $obtainedMarks >= 40 ? 'passed' : 'failed',
                    'remarks' => 'Seeded result for viva demonstration.',
                    'published_at' => now(),
                ]
            );
        }
    }
}
