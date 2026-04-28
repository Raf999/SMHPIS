<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StudentProfile;
use App\Models\TeacherProfile;
use App\Models\Department;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $users = User::with(['studentProfile.department', 'teacherProfile.department'])->latest()->get();
        } elseif ($user->isTeacher()) {
            $teacherDeptId = $user->teacherProfile->department_id;
            
            if (!$teacherDeptId) {
                $users = collect(); // Teacher not assigned to any department
            } else {
                $users = User::where('role', 'student')
                    ->whereHas('studentProfile', function($query) use ($teacherDeptId) {
                        $query->where('department_id', $teacherDeptId);
                    })
                    ->with('studentProfile.department')
                    ->latest()
                    ->get();
            }
        } else {
            abort(403);
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isTeacher()) {
            abort(403);
        }
        
        $teacherDeptId = $user->isTeacher() ? $user->teacherProfile->department_id : null;
        
        if ($user->isTeacher()) {
            $departments = Department::where('id', $teacherDeptId)->with('courses')->get();
        } else {
            $departments = Department::with('courses')->get();
        }
        
        return view('users.create', compact('departments', 'teacherDeptId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:student,teacher',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'student_id_number' => 'required_if:role,student|nullable|string|unique:student_profiles,student_id_number',
            'staff_id' => 'required_if:role,teacher|nullable|string|unique:teacher_profiles,staff_id',
            'department_id' => 'required_if:role,teacher|nullable|exists:departments,id',
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string',
            'department' => 'nullable|string',
        ]);

        $currentUser = Auth::user();
        if ($currentUser->isTeacher()) {
            $request->merge(['department_id' => $currentUser->teacherProfile->department_id]);
        }

        $imagePath = null;
        if ($request->filled('cropped_image')) {
            // Handle base64 cropped image
            $imageData = $request->cropped_image;
            $imagePath = 'profile_images/' . uniqid() . '.jpg';
            
            // Decode and save
            $data = substr($imageData, strpos($imageData, ',') + 1);
            $data = base64_decode($data);
            Storage::disk('public')->put($imagePath, $data);
        } elseif ($request->hasFile('profile_image')) {
            // Fallback for standard upload
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
            'profile_image' => $imagePath,
        ]);

        if ($request->role === 'student') {
            $student = StudentProfile::create([
                'user_id' => $user->id,
                'student_id_number' => $request->student_id_number,
                'department_id' => $request->department_id,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'department' => $request->department,
                'age' => $request->date_of_birth ? \Carbon\Carbon::parse($request->date_of_birth)->age : null,
            ]);

            if ($request->has('courses')) {
                $student->courses()->sync($request->courses);
            }
        } else {
            $teacher = TeacherProfile::create([
                'user_id' => $user->id,
                'staff_id' => $request->staff_id,
                'department_id' => $request->department_id,
            ]);

            if ($request->has('courses')) {
                $teacher->courses()->sync($request->courses);
            }
        }

        return redirect()->route('users.index')->with('status', ucfirst($request->role) . ' created successfully!');
    }
}
