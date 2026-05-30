<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'exam_id' => ['required', 'exists:exams,id'],
            'question_type' => ['required', Rule::in(['mcq', 'subjective'])],
            'question_text' => ['required', 'string'],
            'options' => ['nullable', 'array'],
            'options.*' => ['nullable', 'string'],
            'correct_answer' => ['nullable', 'string'],
            'marks' => ['required', 'integer', 'min:1'],
            'sequence' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'question_type.in' => 'Only MCQ and subjective questions are allowed.',
        ];
    }
}
