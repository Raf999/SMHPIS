<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\StudentProfile;
use App\Models\TeacherProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        // 2. Create Teacher
        $teacher = User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
            'password' => 'password',
            'role' => 'teacher',
        ]);

        $csDept = \App\Models\Department::where('name', 'Computer Science')->first();

        TeacherProfile::create([
            'user_id' => $teacher->id,
            'staff_id' => 'STAFF001',
            'department_id' => $csDept ? $csDept->id : null,
            'department' => 'Computer Science',
            'specialization' => 'Artificial Intelligence',
        ]);

        // 3. Create Student
        $student = User::create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => 'password',
            'role' => 'student',
        ]);

        StudentProfile::create([
            'user_id' => $student->id,
            'student_id_number' => 'STUD001',
            'department_id' => $csDept ? $csDept->id : null,
            'age' => 20,
            'gender' => 'male',
            'department' => 'Computer Science',
            'level' => '300',
        ]);

        // Optional: Create more random students/teachers if needed
    }
}
