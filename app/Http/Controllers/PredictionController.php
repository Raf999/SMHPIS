<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PredictionController extends Controller
{
    private function getPredictions()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return Prediction::with(['student.user', 'input', 'creator'])->latest()->get();
        } elseif ($user->isTeacher()) {
            $deptId = $user->teacherProfile->department_id;
            return Prediction::whereHas('student', function($q) use ($deptId) {
                    $q->where('department_id', $deptId);
                })
                ->with(['student.user', 'input', 'creator'])
                ->latest()
                ->get();
        } else {
            return Prediction::where('student_id', $user->studentProfile->id)
                ->with(['student.user', 'input', 'creator'])
                ->latest()
                ->get();
        }
    }

    public function index()
    {
        $predictions = $this->getPredictions();
        return view('predictions.index', compact('predictions'));
    }

    public function downloadCsv()
    {
        $predictions = $this->getPredictions();

        $filename = 'smhpis_report_logs_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($predictions) {
            $handle = fopen('php://output', 'w');

            // CSV header row
            fputcsv($handle, [
                'Date',
                'Time',
                'Student Name',
                'Student ID',
                'Submitted By',
                'Mood (1-5)',
                'Stress (1-10)',
                'Sleep (hrs)',
                'Physical Activity',
                'Social Interaction',
                'Academic Pressure',
                'Result',
                'Class',
            ]);

            foreach ($predictions as $p) {
                fputcsv($handle, [
                    $p->created_at->format('M d, Y'),
                    $p->created_at->format('h:i A'),
                    $p->student->user->name ?? 'N/A',
                    $p->student->student_id_number ?? 'N/A',
                    $p->creator
                        ? ($p->creator->id === $p->student->user_id ? 'Self' : $p->creator->name)
                        : 'System',
                    $p->input->mood ?? '',
                    $p->input->stress ?? '',
                    $p->input->sleep_hours ?? '',
                    $p->input->physical_activity ?? '',
                    $p->input->social_interaction ?? '',
                    $p->input->academic_pressure ?? '',
                    $p->prediction_result ?? '',
                    $p->prediction_class ?? '',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
