<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student' => $this->student?->name,
            'exam' => $this->exam?->title,
            'obtained_marks' => $this->obtained_marks,
            'total_marks' => $this->total_marks,
            'percentage' => $this->percentage,
            'status' => $this->status,
            'remarks' => $this->remarks,
        ];
    }
}