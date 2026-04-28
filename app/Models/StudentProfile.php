<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $fillable = [
        'user_id',
        'student_id_number',
        'department_id',
        'age',
        'gender',
        'date_of_birth',
        'phone',
        'department',
        'level',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student');
    }

    public function inputs()
    {
        return $this->hasMany(MentalHealthInput::class, 'student_id');
    }

    public function predictions()
    {
        return $this->hasMany(Prediction::class, 'student_id');
    }
}
