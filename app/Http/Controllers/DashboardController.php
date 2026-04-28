<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StudentProfile;
use App\Models\TeacherProfile;
use App\Models\MentalHealthInput;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin' => $this->adminDashboard(),
            'teacher' => $this->teacherDashboard(),
            default => $this->studentDashboard(),
        };
    }

    private function studentDashboard()
    {
        $user = Auth::user();
        $student = $user->studentProfile;

        if (!$student) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Student profile not found. Please contact administration.');
        }

        // Fetch KPIs for Student
        $recentPredictions = MentalHealthInput::where('student_id', $student->id)
            ->latest()
            ->take(5)
            ->get();

        $avgStress = MentalHealthInput::where('student_id', $student->id)->avg('stress') ?? 0;
        $avgSleep = MentalHealthInput::where('student_id', $student->id)->avg('sleep') ?? 0;
        $totalPredictions = MentalHealthInput::where('student_id', $student->id)->count();

        return view('student.dashboard', compact('student', 'recentPredictions', 'avgStress', 'avgSleep', 'totalPredictions'));
    }

    private function teacherDashboard()
    {
        $user = Auth::user();
        $teacher = $user->teacherProfile;

        if (!$teacher) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Teacher profile not found. Please contact administration.');
        }

        // Fetch KPIs for Teacher
        $totalStudents = StudentProfile::count();
        // Match the enum values: 'Healthy', 'At Risk', 'Struggling'
        $highRiskCount = Prediction::where('prediction_result', 'Struggling')->count();
        $avgSystemStress = MentalHealthInput::avg('stress') ?? 0;

        return view('teacher.dashboard', compact('teacher', 'totalStudents', 'highRiskCount', 'avgSystemStress'));
    }

    private function adminDashboard()
    {
        // Fetch KPIs for Admin
        $totalUsers = User::count();
        $studentCount = User::where('role', 'student')->count();
        $teacherCount = User::where('role', 'teacher')->count();
        $totalPredictions = MentalHealthInput::count();

        // Recent activity feed — last 10 predictions with relationships
        $recentPredictions = Prediction::with(['student.user', 'input'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'studentCount', 'teacherCount', 'totalPredictions', 'recentPredictions'
        ));
    }
}
