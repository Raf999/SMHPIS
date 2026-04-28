@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">Reports log</h1>
            <p class="page-subtitle">Audit trail of mental health assessments</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs text-slate-400">{{ $predictions->count() }} record{{ $predictions->count() !== 1 ? 's' : '' }}</span>
            <a href="{{ route('predictions.download') }}" class="btn-secondary gap-2">
                <i class="fas fa-download text-xs"></i>
                Download CSV
            </a>
        </div>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Student</th>
                        <th class="text-center">Mood</th>
                        <th class="text-center">Stress</th>
                        <th>Result</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($predictions as $p)
                    <tr>
                        <td>
                            <p class="text-sm font-medium text-slate-800">{{ $p->created_at->format('M d, Y') }}</p>
                            <p class="text-xs text-slate-400">{{ $p->created_at->format('h:i A') }}</p>
                        </td>
                        <td>
                            <p class="text-sm font-medium text-slate-800">{{ $p->student->user->name }}</p>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="text-xs text-slate-400">{{ $p->student->student_id_number }}</span>
                                <span class="text-slate-200">·</span>
                                <span class="text-xs text-blue-600">
                                    {{ $p->creator ? ($p->creator->id === $p->student->user_id ? 'Self' : $p->creator->name) : 'System' }}
                                </span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="inline-block px-2 py-0.5 bg-slate-50 border border-slate-100 rounded-md text-xs text-slate-600">
                                {{ $p->input->mood }}/5
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="text-sm font-medium text-slate-800">{{ $p->input->stress }}/10</span>
                        </td>
                        <td>
                            @if($p->prediction_result === 'Healthy')
                                <span class="badge-healthy">{{ $p->prediction_result }}</span>
                            @elseif($p->prediction_result === 'Struggling')
                                <span class="badge-struggling">{{ $p->prediction_result }}</span>
                            @else
                                <span class="badge-atrisk">{{ $p->prediction_result }}</span>
                            @endif
                            <span class="text-[11px] text-slate-400 ml-1">[{{ $p->prediction_class }}]</span>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('student.result', $p->id) }}" class="btn-ghost text-xs px-2.5 py-1.5">
                                View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-sm text-slate-400 italic">
                            No prediction logs found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
