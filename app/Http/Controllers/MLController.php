<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MentalHealthInput;
use App\Models\Prediction;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Http;

class MLController extends Controller
{
    /**
     * Show the prediction input form.
     */
    public function showPredictForm()
    {
        $user = Auth::user();
        $students = [];

        if ($user->isAdmin()) {
            $students = StudentProfile::with('user')->get();
        } elseif ($user->isTeacher()) {
            $deptId = $user->teacherProfile->department_id;
            $students = StudentProfile::where('department_id', $deptId)
                ->with('user')
                ->get();
        }

        return view('student.predict', compact('students'));
    }

    /**
     * Handle form submission, store input, and call Flask API.
     */
    public function submitPredict(Request $request)
    {
        $validated = $request->validate([
            'age' => 'required|integer|min:16|max:60',
            'gpa' => 'required|numeric|min:0|max:4',
            'stress' => 'required|integer|min:0|max:10',
            'anxiety' => 'required|integer|min:0|max:10',
            'sleep' => 'required|numeric|min:0|max:24',
            'mood' => 'required|integer|min:1|max:5',
            'reflection' => 'nullable|string',
        ]);

        $user = Auth::user();
        
        // Determine which student we are predicting for
        if (($user->isAdmin() || $user->isTeacher()) && $request->has('student_id')) {
            $studentId = $request->student_id;
            $student = StudentProfile::findOrFail($studentId);
        } else {
            $student = $user->studentProfile;
            $studentId = $student->id;
        }

        // 1. Store the input
        $input = MentalHealthInput::create(array_merge($validated, [
            'student_id' => $studentId,
        ]));

        // 2. Call the AI API
        try {
            $apiUrl = rtrim(env('ML_API_URL', 'http://127.0.0.1:5000'), '/');
            // Original call: $response = Http::timeout(60)->post($apiUrl . '/predict', [
            $response = Http::withoutVerifying()->timeout(60)->post($apiUrl . '/predict', [
                'age' => (int) $validated['age'],
                'gender' => $student->gender ?? 'male', // Use profile gender
                'gpa' => (float) $validated['gpa'],
                'stress' => (int) $validated['stress'],
                'anxiety' => (int) $validated['anxiety'],
                'sleep' => (float) $validated['sleep'],
                'mood' => (string) $validated['mood'],
                'reflection' => $validated['reflection'] ?? '',
            ]);

            if ($response->successful()) {
                $result = $response->json();

                // 3. Save the prediction
                $prediction = Prediction::create([
                    'student_id' => $student->id,
                    'input_id' => $input->id,
                    'prediction_result' => $result['prediction'],
                    'prediction_class' => $result['score'],
                    'advice' => $result['advice'] ?? null,
                    'created_by' => Auth::id(),
                ]);

                return redirect()->route('student.result', $prediction->id)
                    ->with('status', 'AI Prediction Complete!');
            } else {
                return back()->withErrors(['api' => 'The AI server returned an error. Please try again later.']);
            }
        } catch (\Exception $e) {
            \Log::error('AI API Connection Error: ' . $e->getMessage());
            // Original: return back()->withErrors(['api' => 'Could not connect to the AI server. Make sure the Flask API is running.']);
            return back()->withErrors(['api' => 'Could not connect to the AI server. Please make sure the API service is active.']);
        }
    }

    /**
     * Display prediction result.
     */
    public function showResult($id)
    {
        $prediction = Prediction::with('input')->findOrFail($id);
        
        // Ensure students only see their own results
        if (Auth::user()->isStudent() && $prediction->student_id !== Auth::user()->studentProfile->id) {
            abort(403);
        }

        return view('student.result', compact('prediction'));
    }
}
