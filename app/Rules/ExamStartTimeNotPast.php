<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class ExamStartTimeNotPast implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Carbon::parse($value)->lt(Carbon::now())) {
            $fail('The exam start time cannot be in the past.');
        }
    }
}
