@extends('layouts.app')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- Header with dynamic color based on result -->
            <div class="px-8 py-10 text-center {{ $prediction->prediction_result == 'Struggling' ? 'bg-red-50' : ($prediction->prediction_result == 'At Risk' ? 'bg-yellow-50' : 'bg-green-50') }}">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-4 {{ $prediction->prediction_result == 'Struggling' ? 'bg-red-100 text-red-600' : ($prediction->prediction_result == 'At Risk' ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600') }}">
                    @if($prediction->prediction_result == 'Struggling')
                        <i class="fas fa-exclamation-triangle text-3xl"></i>
                    @elseif($prediction->prediction_result == 'At Risk')
                        <i class="fas fa-info-circle text-3xl"></i>
                    @else
                        <i class="fas fa-check-circle text-3xl"></i>
                    @endif
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Prediction Result</h1>
                <p class="text-lg font-medium {{ $prediction->prediction_result == 'Struggling' ? 'text-red-700' : ($prediction->prediction_result == 'At Risk' ? 'text-yellow-700' : 'text-green-700') }}">
                    Status: {{ $prediction->prediction_result }} (Class {{ $prediction->prediction_class }})
                </p>
            </div>

            <div class="px-8 py-10">
                <!-- AI Personalized Advice -->
                <div class="mb-10 p-8 rounded-3xl bg-slate-900 text-white relative overflow-hidden shadow-2xl shadow-blue-500/20">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <i class="fas fa-brain text-6xl"></i>
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="px-2 py-1 bg-blue-500 rounded text-[10px] font-bold uppercase tracking-widest">AI Counselor</span>
                            <span class="text-xs font-medium text-slate-400">Generated tailored advice</span>
                        </div>
                        <p class="text-lg font-medium leading-relaxed italic">
                            "{{ $prediction->advice ?? 'Our AI model indicates you should continue maintaining your positive habits and healthy lifestyle.' }}"
                        </p>
                    </div>
                </div>

                <!-- Input Breakdown -->
                <div class="grid grid-cols-2 gap-4 mb-10">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Reported Stress</span>
                        <p class="text-xl font-bold text-gray-800">{{ $prediction->input->stress }}/10</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Sleep Duration</span>
                        <p class="text-xl font-bold text-gray-800">{{ $prediction->input->sleep }} Hours</p>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="border-t border-gray-100 pt-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Recommended Next Steps</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-arrow-right text-teal-500 mt-1 mr-3 text-sm"></i>
                            <span class="text-gray-600 text-sm">Schedule a session with the university counseling unit.</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-arrow-right text-teal-500 mt-1 mr-3 text-sm"></i>
                            <span class="text-gray-600 text-sm">Try to maintain a consistent sleep schedule of 7-8 hours.</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-arrow-right text-teal-500 mt-1 mr-3 text-sm"></i>
                            <span class="text-gray-600 text-sm">Use the daily reflection tool to track your emotional trends.</span>
                        </li>
                    </ul>
                </div>

                <!-- Actions -->
                <div class="mt-10 flex space-x-4">
                    <a href="{{ route('student.dashboard') }}" class="flex-1 text-center py-3 px-6 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition duration-300">
                        Go to Dashboard
                    </a>
                    <a href="{{ route('student.predict') }}" class="flex-1 text-center py-3 px-6 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 shadow-md transition duration-300">
                        New Test
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
