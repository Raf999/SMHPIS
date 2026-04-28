@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Reports Log</h1>
            <p class="text-slate-500 font-medium mt-1">Audit trail of mental health assessments</p>
        </div>
        <div class="mt-4 md:mt-0 flex items-center space-x-3">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $predictions->count() }} record(s)</span>
            <a href="{{ route('predictions.download') }}"
               class="btn-primary flex items-center space-x-2 !py-3 !px-5">
                <i class="fas fa-download"></i>
                <span>Download CSV</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-[3rem] shadow-sm border border-gray-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-dashboard-bg/50 text-[10px] uppercase font-black text-gray-400 tracking-[0.2em]">
                    <tr>
                        <th class="px-8 py-6">Date</th>
                        <th class="px-8 py-6">Subject</th>
                        <th class="px-8 py-6 text-center">Mood</th>
                        <th class="px-8 py-6 text-center">Stress</th>
                        <th class="px-8 py-6">Inference</th>
                        <th class="px-8 py-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($predictions as $p)
                    <tr class="hover:bg-dashboard-bg/30 transition-colors group">
                        <td class="px-8 py-6">
                            <p class="font-black text-gray-900 text-xs tracking-tight">{{ $p->created_at->format('M d, Y') }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">{{ $p->created_at->format('h:i A') }}</p>
                        </td>
                        <td class="px-8 py-6">
                            <p class="font-black text-gray-900 text-sm tracking-tight">{{ $p->student->user->name }}</p>
                            <div class="flex items-center mt-1">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $p->student->student_id_number }}</p>
                                <span class="mx-2 text-gray-200">•</span>
                                <p class="text-[10px] font-bold text-teal-600 uppercase tracking-widest">
                                    By: {{ $p->creator ? ($p->creator->id === $p->student->user_id ? 'Self' : $p->creator->name) : 'System' }}
                                </p>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="inline-block px-3 py-1 bg-white rounded-xl shadow-sm border border-gray-100 text-[10px] font-black text-gray-600">
                                {{ $p->input->mood }}/5
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <p class="text-sm font-black text-gray-900">{{ $p->input->stress }}/10</p>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $p->prediction_result == 'Struggling' ? 'bg-red-50 text-red-600' : ($p->prediction_result == 'At Risk' ? 'bg-orange-50 text-orange-600' : 'bg-green-50 text-green-600') }}">
                                {{ $p->prediction_result }} [{{ $p->prediction_class }}]
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('student.result', $p->id) }}" class="h-10 px-4 bg-white rounded-xl shadow-sm border border-gray-100 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-teal-500 hover:border-teal-200 transition-all inline-flex items-center">
                                View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">
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
