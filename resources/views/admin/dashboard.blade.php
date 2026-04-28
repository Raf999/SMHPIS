@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <nav class="flex text-xs font-bold text-gray-400 uppercase tracking-widest mb-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li>Pages</li>
                <li><span class="mx-2 text-gray-300">/</span></li>
                <li class="text-gray-900">Dashboard</li>
            </ol>
        </nav>
        <h1 class="text-2xl font-black text-gray-900 tracking-tight">Admin Console</h1>
        <p class="text-gray-400 text-sm font-medium">Monitoring platform activity and system health.</p>
    </div>

    <!-- KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-5 rounded-3xl soft-shadow flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Users</p>
                <h3 class="text-xl font-black text-gray-900">{{ $totalUsers }}</h3>
            </div>
            <div class="h-12 w-12 bg-slate-900 rounded-xl flex items-center justify-center text-white shadow-lg">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-3xl soft-shadow flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Students</p>
                <h3 class="text-xl font-black text-gray-900">{{ $studentCount }}</h3>
            </div>
            <div class="h-12 w-12 bg-accent-blue rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                <i class="fas fa-user-graduate"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-3xl soft-shadow flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Faculty</p>
                <h3 class="text-xl font-black text-gray-900">{{ $teacherCount }}</h3>
            </div>
            <div class="h-12 w-12 bg-accent-purple rounded-xl flex items-center justify-center text-white shadow-lg shadow-purple-500/20">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-3xl soft-shadow flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">AI Logs</p>
                <h3 class="text-xl font-black text-gray-900">{{ $totalPredictions }}</h3>
            </div>
            <div class="h-12 w-12 bg-slate-800 rounded-xl flex items-center justify-center text-white shadow-lg">
                <i class="fas fa-microchip"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Chart Area -->
        <div class="lg:col-span-2 bg-white p-8 rounded-3xl soft-shadow">
            <h3 class="text-lg font-black text-gray-900 tracking-tight mb-6">Platform Distribution</h3>
            <div class="space-y-10">
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Student Engagement</span>
                        <span class="text-xs font-black text-gray-900">{{ number_format(($studentCount/$totalUsers)*100, 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-accent-blue h-1.5 rounded-full" style="width: {{ ($studentCount/$totalUsers)*100 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Faculty Activity</span>
                        <span class="text-xs font-black text-gray-900">{{ number_format(($teacherCount/$totalUsers)*100, 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-accent-purple h-1.5 rounded-full" style="width: {{ ($teacherCount/$totalUsers)*100 }}%"></div>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 p-6 bg-dashboard-bg rounded-2xl flex items-center justify-between border border-gray-100">
                <div class="flex items-center">
                    <div class="h-10 w-10 bg-white rounded-xl soft-shadow flex items-center justify-center text-accent-blue mr-4">
                        <i class="fas fa-server"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-gray-900 uppercase tracking-tight">System Status</h4>
                        <p class="text-[10px] font-bold text-gray-400">All systems operational • 1.2s API Response</p>
                    </div>
                </div>
                <div class="flex -space-x-3">
                    <div class="h-8 w-8 rounded-full border-2 border-white bg-blue-100"></div>
                    <div class="h-8 w-8 rounded-full border-2 border-white bg-purple-100"></div>
                    <div class="h-8 w-8 rounded-full border-2 border-white bg-gray-100"></div>
                </div>
            </div>
        </div>

        <!-- Management Area -->
        <div class="bg-gradient-to-br from-accent-blue to-accent-purple p-8 rounded-3xl shadow-xl flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute inset-0 bg-pattern opacity-10"></div>
            <div class="relative z-10">
                <div class="h-12 w-12 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center text-white mb-6">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="text-2xl font-black text-white leading-tight mb-2">User Access <br> Management</h3>
                <p class="text-white/70 text-xs font-bold uppercase tracking-widest">Provision & Review Accounts</p>
            </div>
            <div class="relative z-10 mt-12">
                <a href="{{ route('users.index') }}" class="inline-flex items-center px-8 py-3 bg-white text-gray-900 font-black text-[10px] uppercase tracking-widest rounded-xl hover:scale-105 transition-transform shadow-lg">
                    Manage Directory
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
