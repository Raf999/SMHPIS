<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    protected $fillable = [
        'student_id',
        'created_by',
        'input_id',
        'prediction_result',
        'prediction_class',
        'prob_low',
        'prob_mid',
        'prob_high',
        'model_used',
        'recommendation',
        'advice',
    ];

    public function student()
    {
        return $this->belongsTo(StudentProfile::class, 'student_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function input()
    {
        return $this->belongsTo(MentalHealthInput::class, 'input_id');
    }
}
