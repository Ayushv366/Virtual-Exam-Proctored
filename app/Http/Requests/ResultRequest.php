<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'exists:users,id'],
            'exam_id' => ['required', 'exists:exams,id'],
            'obtained_marks' => ['required', 'numeric', 'min:0'],
            'total_marks' => ['required', 'numeric', 'min:1'],
            'percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'status' => ['required', 'in:passed,failed,pending'],
            'remarks' => ['nullable', 'string'],
        ];
    }
}
