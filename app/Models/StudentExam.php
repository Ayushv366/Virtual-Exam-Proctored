<?php

namespace App\Models;

use Database\Factories\StudentExamFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentExam extends Model
{
    /** @use HasFactory<StudentExamFactory> */
    use HasFactory;

    protected $table = 'student_exams';

    protected $fillable = [
        'student_id',
        'exam_id',
        'started_at',
        'submitted_at',
        'score',
        'status',
        'attempt_data',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'score' => 'decimal:2',
        'attempt_data' => 'array',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
}
