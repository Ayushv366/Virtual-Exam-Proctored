<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class CameraLog extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'camera_logs';

    protected $fillable = [
        'student_id',
        'image_path',
        'captured_at',
        'meta',
    ];

    protected $casts = [
        'captured_at' => 'datetime',
        'meta' => 'array',
    ];
}