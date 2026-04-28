<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentalHealthInput extends Model
{
    protected $fillable = [
        'student_id',
        'age',
        'gpa',
        'stress',
        'anxiety',
        'sleep',
        'mood',
        'reflection',
    ];

    public function student()
    {
        return $this->belongsTo(StudentProfile::class, 'student_id');
    }

    public function prediction()
    {
        return $this->hasOne(Prediction::class, 'input_id');
    }
}
