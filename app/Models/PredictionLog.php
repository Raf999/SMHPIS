<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PredictionLog extends Model
{
    protected $fillable = [
        'student_id',
        'input_snapshot',
        'prediction_output',
    ];

    protected $casts = [
        'input_snapshot' => 'array',
        'prediction_output' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(StudentProfile::class, 'student_id');
    }
}
