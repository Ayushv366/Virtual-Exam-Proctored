<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
        $faculty = User::query()->where('role', 'faculty')->get();
        $subjects = Subject::query()->get();

        foreach ($subjects->take(3) as $index => $subject) {
            Exam::updateOrCreate(
                ['room_code' => 'ROOM-'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT)],
                [
                    'subject_id' => $subject->id,
                    'faculty_id' => $faculty[$index % max(1, $faculty->count())]->id,
                    'title' => $subject->name.' Viva Practice',
                    'instructions' => 'Open the exam hall in full screen, do not switch tabs, and allow camera capture.',
                    'start_time' => now()->addDays($index + 1)->setHour(10),
                    'end_time' => now()->addDays($index + 1)->setHour(12),
                    'duration_minutes' => 120,
                    'total_marks' => 100,
                    'passing_marks' => 40,
                    'is_active' => $index === 0,
                    'published_at' => now(),
                ]
            );
        }
    }
}
