@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">

    @php
        $isStruggling = $prediction->prediction_result === 'Struggling';
        $isAtRisk = $prediction->prediction_result === 'At Risk';
        $isHealthy = $prediction->prediction_result === 'Healthy';
    @endphp

    {{-- Result header --}}
    <div class="card mb-5 p-6">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 rounded-xl flex items-center justify-center shrink-0
                {{ $isStruggling ? 'bg-red-50' : ($isAtRisk ? 'bg-amber-50' : 'bg-green-50') }}">
                <i class="fas text-xl
                   {{ $isStruggling ? 'fa-exclamation-triangle text-red-500' : ($isAtRisk ? 'fa-info-circle text-amber-500' : 'fa-check-circle text-green-500') }}"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-1">Prediction result</p>
                <div class="flex items-center gap-2">
                    @if($isHealthy)
                        <span class="badge-healthy text-sm px-3 py-1">{{ $prediction->prediction_result }}</span>
                    @elseif($isStruggling)
                        <span class="badge-struggling text-sm px-3 py-1">{{ $prediction->prediction_result }}</span>
                    @else
                        <span class="badge-atrisk text-sm px-3 py-1">{{ $prediction->prediction_result }}</span>
                    @endif
                    <span class="text-xs text-slate-400">Class {{ $prediction->prediction_class }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- AI advice --}}
    <div class="card mb-5 p-6 bg-slate-900 border-slate-900">
        <div class="flex items-center gap-2 mb-4">
            <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-blue-600 rounded text-[11px] font-medium text-white">
                <i class="fas fa-brain text-[10px]"></i>
                AI Counselor
            </span>
            <span class="text-xs text-slate-500">Personalized advice</span>
        </div>
        <p class="text-sm text-slate-200 leading-relaxed italic">
            "{{ $prediction->advice ?? 'Continue maintaining your positive habits and healthy lifestyle.' }}"
        </p>
    </div>

    {{-- Input breakdown --}}
    <div class="card mb-5 p-5">
        <h2 class="text-sm font-semibold text-slate-900 mb-4">Input breakdown</h2>
        <div class="grid grid-cols-2 gap-3">
            <div class="bg-slate-50 rounded-lg p-4">
                <p class="text-xs text-slate-500 mb-1">Stress reported</p>
                <p class="text-xl font-semibold text-slate-900">{{ $prediction->input->stress }}<span class="text-sm font-normal text-slate-400">/10</span></p>
            </div>
            <div class="bg-slate-50 rounded-lg p-4">
                <p class="text-xs text-slate-500 mb-1">Sleep duration</p>
                <p class="text-xl font-semibold text-slate-900">{{ $prediction->input->sleep }}<span class="text-sm font-normal text-slate-400">h</span></p>
            </div>
            <div class="bg-slate-50 rounded-lg p-4">
                <p class="text-xs text-slate-500 mb-1">Anxiety score</p>
                <p class="text-xl font-semibold text-slate-900">{{ $prediction->input->anxiety }}<span class="text-sm font-normal text-slate-400">/10</span></p>
            </div>
            <div class="bg-slate-50 rounded-lg p-4">
                <p class="text-xs text-slate-500 mb-1">Mood</p>
                <p class="text-xl font-semibold text-slate-900">{{ $prediction->input->mood }}<span class="text-sm font-normal text-slate-400">/5</span></p>
            </div>
        </div>
    </div>

    {{-- Recommendations --}}
    <div class="card mb-6 p-5">
        <h2 class="text-sm font-semibold text-slate-900 mb-4">Recommended next steps</h2>
        <ul class="space-y-3">
            <li class="flex items-start gap-3">
                <i class="fas fa-circle-dot text-blue-500 text-xs mt-1 shrink-0"></i>
                <span class="text-sm text-slate-600">Schedule a session with the university counseling unit.</span>
            </li>
            <li class="flex items-start gap-3">
                <i class="fas fa-circle-dot text-blue-500 text-xs mt-1 shrink-0"></i>
                <span class="text-sm text-slate-600">Aim for a consistent sleep schedule of 7–8 hours nightly.</span>
            </li>
            <li class="flex items-start gap-3">
                <i class="fas fa-circle-dot text-blue-500 text-xs mt-1 shrink-0"></i>
                <span class="text-sm text-slate-600">Use the daily reflection tool to track your emotional trends over time.</span>
            </li>
        </ul>
    </div>

    {{-- Actions --}}
    <div class="flex gap-3">
        <a href="{{ route('student.dashboard') }}" class="btn-secondary flex-1 justify-center py-2.5">
            Go to dashboard
        </a>
        <a href="{{ route('student.predict') }}" class="btn-primary flex-1 justify-center py-2.5">
            New check-in
        </a>
    </div>

</div>
@endsection
