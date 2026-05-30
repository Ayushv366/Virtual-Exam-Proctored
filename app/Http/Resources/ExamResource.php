<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->subject?->name,
            'title' => $this->title,
            'instructions' => $this->instructions,
            'start_time' => optional($this->start_time)->toIso8601String(),
            'end_time' => optional($this->end_time)->toIso8601String(),
            'duration_minutes' => $this->duration_minutes,
            'total_marks' => $this->total_marks,
            'passing_marks' => $this->passing_marks,
            'room_code' => $this->room_code,
            'is_active' => (bool) $this->is_active,
        ];
    }
}