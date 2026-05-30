<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        Exam::query()->get()->each(function (Exam $exam): void {
            Question::updateOrCreate(
                ['exam_id' => $exam->id, 'sequence' => 1],
                [
                    'question_type' => 'mcq',
                    'question_text' => 'Which SQL clause is used to filter grouped rows?',
                    'options' => ['WHERE', 'HAVING', 'ORDER BY', 'LIMIT'],
                    'correct_answer' => 'HAVING',
                    'marks' => 5,
                    'sequence' => 1,
                ]
            );

            Question::updateOrCreate(
                ['exam_id' => $exam->id, 'sequence' => 2],
                [
                    'question_type' => 'subjective',
                    'question_text' => 'Explain the role of middleware in Laravel security.',
                    'options' => null,
                    'correct_answer' => null,
                    'marks' => 10,
                    'sequence' => 2,
                ]
            );
        });
    }
}
