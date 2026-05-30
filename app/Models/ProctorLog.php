<?php

namespace App\Models;

use Database\Factories\ProctorLogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProctorLog extends Model
{
    /** @use HasFactory<ProctorLogFactory> */
    use HasFactory;

    protected $fillable = [
        'student_id',
        'exam_id',
        'violation_type',
        'description',
        'timestamp',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
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
