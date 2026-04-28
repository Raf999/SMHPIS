<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StudentProfile;
use App\Models\TeacherProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /*
    |-------------------------------------------------
    | REGISTER FORM
    |-------------------------------------------------
    */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /*
    |-------------------------------------------------
    | REGISTER USER
    |-------------------------------------------------
    */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:student,teacher',

            // student fields
            'student_id_number' => 'nullable|string|unique:student_profiles,student_id_number',
            'age' => 'nullable|integer|min:16|max:60',
            'gender' => 'nullable|in:male,female,other',
            'department' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',

            // teacher fields
            'staff_id' => 'nullable|string|unique:teacher_profiles,staff_id',
            'specialization' => 'nullable|string|max:255',
        ]);

        $profileImagePath = null;
        if ($request->filled('cropped_image')) {
            $imageData = $request->input('cropped_image');
            $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
            $imageName = 'profile_' . time() . '.jpg';
            \Illuminate\Support\Facades\Storage::disk('public')->put('profile_images/' . $imageName, base64_decode($imageData));
            $profileImagePath = 'profile_images/' . $imageName;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'profile_image' => $profileImagePath,
        ]);

        // CREATE STUDENT PROFILE
        if ($request->role === 'student') {
            StudentProfile::create([
                'user_id' => $user->id,
                'student_id_number' => $request->student_id_number,
                'department_id' => $request->department_id ?? null,
                'age' => $request->age,
                'gender' => $request->gender,
                'department' => $request->department,
                'level' => $request->level,
            ]);
        }

        // CREATE TEACHER PROFILE
        if ($request->role === 'teacher') {
            TeacherProfile::create([
                'user_id' => $user->id,
                'staff_id' => $request->staff_id,
                'department' => $request->department,
                'department_id' => $request->department_id ?? null,
                'specialization' => $request->specialization,
            ]);
        }

        Auth::login($user);

        // ROLE-BASED REDIRECT (IMPORTANT FIX)
        return match ($user->role) {
            'admin' => redirect('/admin/dashboard'),
            'teacher' => redirect('/teacher/dashboard'),
            default => redirect('/student/dashboard'),
        };
    }

    /*
    |-------------------------------------------------
    | LOGIN FORM
    |-------------------------------------------------
    */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /*
    |-------------------------------------------------
    | LOGIN
    |-------------------------------------------------
    */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials, $request->remember)) {
            \Illuminate\Support\Facades\Log::info('Login failed for email: ' . $credentials['email']);
            $userExists = \App\Models\User::where('email', $credentials['email'])->exists();
            return back()->withErrors([
                'email' => $userExists ? 'Invalid password' : 'User not found'
            ])->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        $user = Auth::user();

        return match ($user->role) {
            'admin' => redirect('/admin/dashboard'),
            'teacher' => redirect('/teacher/dashboard'),
            default => redirect('/student/dashboard'),
        };
    }

    /*
    |-------------------------------------------------
    | LOGOUT
    |-------------------------------------------------
    */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}