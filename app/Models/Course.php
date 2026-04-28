<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'code', 'department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(TeacherProfile::class, 'course_teacher');
    }

    public function students()
    {
        return $this->belongsToMany(StudentProfile::class, 'course_student');
    }
}
