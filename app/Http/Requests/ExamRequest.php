<?php

namespace App\Http\Requests;

use App\Rules\ExamStartTimeNotPast;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $examId = $this->route('exam')?->id;

        return [
            'subject_id' => ['required', 'exists:subjects,id'],
            'faculty_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'instructions' => ['nullable', 'string'],
            'start_time' => ['required', 'date', new ExamStartTimeNotPast()],
            'end_time' => ['required', 'date', 'after:start_time'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:720'],
            'total_marks' => ['required', 'integer', 'min:1'],
            'passing_marks' => ['required', 'integer', 'min:1', 'lt:total_marks'],
            'room_code' => ['required', 'string', 'max:50', Rule::unique('exams', 'room_code')->ignore($examId)],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'end_time.after' => 'The exam end time must be after the start time.',
            'passing_marks.lt' => 'Passing marks must be less than total marks.',
            'room_code.unique' => 'This exam room code is already in use.',
        ];
    }
}
