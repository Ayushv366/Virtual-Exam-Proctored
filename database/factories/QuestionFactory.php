<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    public function definition(): array
    {
        $type = fake()->randomElement(['mcq', 'subjective']);

        return [
            'exam_id' => Exam::factory(),
            'question_type' => $type,
            'question_text' => fake()->sentence(10).'? ',
            'options' => $type === 'mcq' ? [fake()->word(), fake()->word(), fake()->word(), fake()->word()] : null,
            'correct_answer' => $type === 'mcq' ? fake()->word() : null,
            'marks' => fake()->numberBetween(1, 5),
            'sequence' => fake()->numberBetween(1, 20),
        ];
    }
}
