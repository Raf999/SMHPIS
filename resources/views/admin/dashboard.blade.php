@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <!-- Top Bar / Breadcrumbs -->
    <div class="flex items-center justify-between mb-10">
        <div>
            <nav class="flex text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">
                <ol class="flex items-center space-x-2">
                    <li>Dashboard</li>
                    <li class="text-slate-300 mx-2">/</li>
                    <li class="text-slate-900">Overview</li>
                </ol>
            </nav>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Overview</h1>
            <p class="text-slate-400 font-medium text-sm mt-1">Welcome to the SMHPIS Admin Dashboard.</p>
        </div>
        <div class="flex items-center space-x-4">
            <button class="h-10 w-10 flex items-center justify-center bg-white rounded-xl shadow-soft text-slate-400 hover:text-primary transition-colors">
                <i class="far fa-bell"></i>
            </button>
            <div class="flex items-center space-x-3 bg-white p-1.5 pr-6 rounded-2xl shadow-soft border border-slate-50">
                <div class="h-8 w-8 rounded-xl overflow-hidden bg-slate-900">
                    @if(Auth::user()->profile_image_url)
                        <img src="{{ Auth::user()->profile_image_url }}" class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full flex items-center justify-center text-white text-xs font-black">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    @endif
                </div>
                <div class="hidden lg:block">
                    <p class="text-[10px] font-black text-slate-900 leading-none">{{ Auth::user()->name }}</p>
                    <p class="text-[8px] font-bold text-slate-400 uppercase mt-1">Manager</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Card 1 -->
        <div class="card-premium p-8 flex flex-col justify-between h-44">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total System Users</p>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tighter">{{ $totalUsers }}</h3>
                </div>
                <div class="h-10 w-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xs">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="flex items-center text-green-500 text-[10px] font-black uppercase tracking-widest">
                <i class="fas fa-arrow-up mr-1.5"></i>
                <span>+{{ rand(2, 5) }}% vs last week</span>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="card-premium p-8 flex flex-col justify-between h-44">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Student Profiles</p>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tighter">{{ $studentCount }}</h3>
                </div>
                <div class="h-10 w-10 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center text-xs">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                Verified Students
            </div>
        </div>

        <!-- Card 3 -->
        <div class="card-premium p-8 flex flex-col justify-between h-44">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Pending Reviews</p>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tighter">{{ rand(1, 10) }}</h3>
                </div>
                <div class="h-10 w-10 bg-green-50 text-green-500 rounded-xl flex items-center justify-center text-xs">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                Awaiting Analysis
            </div>
        </div>

        <!-- Card 4 -->
        <div class="card-premium p-8 flex flex-col justify-between h-44">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Predictions</p>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tighter">{{ $totalPredictions }}</h3>
                </div>
                <div class="h-10 w-10 bg-slate-900 text-white rounded-xl flex items-center justify-center text-xs">
                    <i class="fas fa-microchip"></i>
                </div>
            </div>
            <div class="flex items-center text-green-500 text-[10px] font-black uppercase tracking-widest">
                <i class="fas fa-arrow-up mr-1.5"></i>
                <span>Active engine</span>
            </div>
        </div>
    </div>

    <!-- Charts and Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Left: Analysis Trend -->
        <div class="lg:col-span-3 card-premium p-10">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight">Mental Health Trends <span class="text-slate-300 font-medium ml-1 text-sm">(Last 30 Days)</span></h3>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="h-8 w-8 rounded-lg bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-slate-100 transition-colors">
                        <i class="fas fa-download text-[10px]"></i>
                    </button>
                </div>
            </div>
            
            <div class="h-64 w-full relative">
                <!-- Chart Placeholder - You can integrate Chart.js here -->
                <canvas id="mentalHealthChart"></canvas>
            </div>
        </div>

        <!-- Right: Recent Activity -->
        <div class="card-premium p-8">
            <h3 class="text-sm font-black text-slate-900 mb-6 uppercase tracking-widest">Recent Activity</h3>
            <div class="space-y-6">
                @foreach(range(1, 3) as $i)
                <div class="flex flex-col">
                    <div class="flex items-center justify-between mb-2">
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[9px] font-black uppercase tracking-widest">Analysis</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase">Just now</span>
                    </div>
                    <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-50">
                        <p class="text-xs font-black text-slate-800 tracking-tight">New prediction generated for Student ID #{{ rand(100, 999) }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-10 pt-6 border-t border-slate-50">
                <h4 class="text-[10px] font-black text-slate-900 mb-4 uppercase tracking-widest">System Load</h4>
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 rounded-xl bg-slate-50 flex items-center justify-center text-primary text-xs font-black italic">S</div>
                    <div>
                        <p class="text-[10px] font-black text-slate-900 tracking-tight">Server Health: Excellent</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">1.2ms latency</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Integration -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('mentalHealthChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(29, 78, 216, 0.2)');
    gradient.addColorStop(1, 'rgba(29, 78, 216, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: Array.from({length: 30}, (_, i) => i + 1),
            datasets: [{
                label: 'Stress Index',
                data: Array.from({length: 30}, () => Math.floor(Math.random() * 5) + 3),
                borderColor: '#1d4ed8',
                borderWidth: 3,
                fill: true,
                backgroundColor: gradient,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#1d4ed8',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 10,
                    grid: { display: false, drawBorder: false },
                    ticks: { display: false }
                },
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: { display: false }
                }
            }
        }
    });
</script>
@endsection
