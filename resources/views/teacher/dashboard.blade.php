@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <nav class="flex text-xs font-bold text-gray-400 uppercase tracking-widest mb-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li>Pages</li>
                <li><span class="mx-2 text-gray-300">/</span></li>
                <li class="text-gray-900">Academic Dashboard</li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight">Academic Oversight</h1>
                <p class="text-gray-400 text-sm font-medium">Faculty: {{ $teacher->department ?? 'General Studies' }}</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('users.create') }}" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:scale-105 transition-transform shadow-lg shadow-blue-500/20">
                    <i class="fas fa-plus mr-2"></i> Onboard Student
                </a>
            </div>
        </div>
    </div>

    <!-- KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-3xl soft-shadow flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Students</p>
                <h3 class="text-xl font-black text-gray-900">{{ $totalStudents }}</h3>
            </div>
            <div class="h-12 w-12 bg-slate-900 rounded-xl flex items-center justify-center text-white shadow-lg">
                <i class="fas fa-user-graduate"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-3xl soft-shadow flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Students at Risk</p>
                <h3 class="text-xl font-black text-red-500">{{ $highRiskCount }}</h3>
            </div>
            <div class="h-12 w-12 bg-red-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-red-500/20">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-3xl soft-shadow flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Avg System Stress</p>
                <h3 class="text-xl font-black text-gray-900">{{ number_format($avgSystemStress, 1) }}</h3>
            </div>
            <div class="h-12 w-12 bg-accent-blue rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                <i class="fas fa-chart-bar"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Observation Area -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-8 rounded-3xl soft-shadow">
                <h3 class="text-lg font-black text-gray-900 tracking-tight mb-6">Proactive Observations</h3>
                <div class="p-6 bg-blue-50/50 border border-blue-100 rounded-2xl flex items-start">
                    <div class="h-10 w-10 bg-accent-blue text-white rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-blue-500/20">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="ml-5">
                        <h4 class="text-sm font-black text-gray-900 leading-tight">Intervention Suggested</h4>
                        <p class="text-xs font-medium text-gray-500 mt-1 leading-relaxed">
                            System analysis indicates that <span class="font-black text-accent-blue">{{ $highRiskCount }}</span> students in your department require immediate wellness follow-ups based on their latest stress data.
                        </p>
                    </div>
                </div>
                
                <div class="mt-10">
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Class Analytics</h4>
                    <div class="h-40 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-100 flex items-center justify-center">
                        <p class="text-gray-400 font-bold text-xs italic">Stress heat-map visualization loading...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-8">
            <div class="bg-white p-8 rounded-3xl soft-shadow">
                <h3 class="text-lg font-black text-gray-900 tracking-tight mb-6">Export Data</h3>
                <p class="text-xs font-medium text-gray-500 mb-6">Download department reports for administrative review.</p>
                <div class="grid grid-cols-2 gap-4">
                    <button class="flex flex-col items-center justify-center p-4 bg-gray-50 hover:bg-gray-100 rounded-2xl transition-colors group">
                        <i class="fas fa-file-pdf text-red-500 mb-2"></i>
                        <span class="text-[10px] font-black uppercase text-gray-400 group-hover:text-gray-600">PDF</span>
                    </button>
                    <button class="flex flex-col items-center justify-center p-4 bg-gray-50 hover:bg-gray-100 rounded-2xl transition-colors group">
                        <i class="fas fa-file-excel text-green-500 mb-2"></i>
                        <span class="text-[10px] font-black uppercase text-gray-400 group-hover:text-gray-600">Excel</span>
                    </button>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-8 rounded-3xl shadow-xl">
                <h3 class="text-lg font-black text-white mb-4">Quick Links</h3>
                <div class="space-y-3">
                    <a href="{{ route('users.index') }}" class="flex items-center p-3 bg-white/10 hover:bg-white/20 rounded-xl text-white transition-all group">
                        <i class="fas fa-users-cog mr-3 text-white/50 group-hover:text-white transition-colors"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest">My Students</span>
                    </a>
                    <a href="{{ route('predictions.index') }}" class="flex items-center p-3 bg-white/10 hover:bg-white/20 rounded-xl text-white transition-all group">
                        <i class="fas fa-history mr-3 text-white/50 group-hover:text-white transition-colors"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest">Risk Logs</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
