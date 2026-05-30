<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\ProctorLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProctorLogSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::query()->where('role', 'student')->get();
        $exams = Exam::query()->get();

        foreach ($students->take(4) as $index => $student) {
            $exam = $exams[$index % max(1, $exams->count())];

            ProctorLog::updateOrCreate(
                ['student_id' => $student->id, 'exam_id' => $exam->id, 'violation_type' => 'tab_switch'],
                [
                    'description' => 'Student switched tabs during the seeded exam session.',
                    'timestamp' => now()->subMinutes(30 + ($index * 5)),
                ]
            );
        }
    }
}
