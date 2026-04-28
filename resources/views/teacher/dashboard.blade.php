@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">Academic Oversight</h1>
            <p class="page-subtitle">{{ $teacher->department ?? 'General Studies' }}</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn-primary self-start">
            <i class="fas fa-plus text-xs"></i> Onboard student
        </a>
    </div>

    {{-- KPI cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">

        <div class="stat-card border-l-2 border-blue-400">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs text-slate-500">Total students</p>
                <div class="h-7 w-7 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-graduate text-blue-600 text-[11px]"></i>
                </div>
            </div>
            <p class="text-2xl font-semibold text-slate-900">{{ $totalStudents }}</p>
            <p class="text-xs text-slate-400 mt-1">Enrolled in system</p>
        </div>

        <div class="stat-card border-l-2 border-red-300">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs text-slate-500">Struggling</p>
                <div class="h-7 w-7 bg-red-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-500 text-[11px]"></i>
                </div>
            </div>
            <p class="text-2xl font-semibold text-red-600">{{ $highRiskCount }}</p>
            <p class="text-xs text-slate-400 mt-1">Require follow-up</p>
        </div>

        <div class="stat-card border-l-2 border-indigo-300">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs text-slate-500">Avg stress</p>
                <div class="h-7 w-7 bg-indigo-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-bar text-indigo-600 text-[11px]"></i>
                </div>
            </div>
            <p class="text-2xl font-semibold text-slate-900">{{ number_format($avgSystemStress,1) }}</p>
            <p class="text-xs text-slate-400 mt-1">System-wide /10</p>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Main panel --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Alert --}}
            <div class="{{ $highRiskCount > 0 ? 'alert-warning' : 'alert-success' }}">
                <i class="fas {{ $highRiskCount > 0 ? 'fa-exclamation-triangle text-amber-500' : 'fa-check-circle text-green-500' }} text-sm shrink-0 mt-0.5"></i>
                <div>
                    <p class="text-sm font-medium text-slate-800">
                        @if($highRiskCount > 0)
                            {{ $highRiskCount }} student{{ $highRiskCount > 1 ? 's' : '' }} flagged as <strong>Struggling</strong>
                        @else
                            No students currently flagged
                        @endif
                    </p>
                    <p class="text-xs text-slate-500 mt-0.5">
                        @if($highRiskCount > 0)
                            Immediate wellness follow-ups are recommended.
                        @else
                            All students appear to be in good standing. Keep monitoring regularly.
                        @endif
                    </p>
                </div>
            </div>

            {{-- Distribution chart --}}
            <div class="card p-6">
                <div class="mb-5">
                    <h2 class="text-sm font-semibold text-slate-900">Stress Distribution</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Student wellness breakdown</p>
                </div>
                <div class="h-48">
                    <canvas id="stressDistChart"></canvas>
                </div>
            </div>

        </div>

        {{-- Sidebar --}}
        <div class="space-y-5">

            <div class="card p-5">
                <h2 class="text-sm font-semibold text-slate-900 mb-4">Quick links</h2>
                <div class="space-y-1">
                    <a href="{{ route('users.index') }}" class="flex items-center justify-between p-3 rounded-lg text-sm text-slate-600 hover:bg-slate-50 transition-colors group">
                        <span class="flex items-center gap-3">
                            <i class="fas fa-users text-slate-400 text-xs w-4 text-center"></i>
                            My students
                        </span>
                        <i class="fas fa-chevron-right text-slate-300 text-[10px] group-hover:text-slate-500 transition-colors"></i>
                    </a>
                    <a href="{{ route('predictions.index') }}" class="flex items-center justify-between p-3 rounded-lg text-sm text-slate-600 hover:bg-slate-50 transition-colors group">
                        <span class="flex items-center gap-3">
                            <i class="fas fa-history text-slate-400 text-xs w-4 text-center"></i>
                            Risk logs
                        </span>
                        <i class="fas fa-chevron-right text-slate-300 text-[10px] group-hover:text-slate-500 transition-colors"></i>
                    </a>
                    <a href="{{ route('student.predict') }}" class="flex items-center justify-between p-3 rounded-lg text-sm text-slate-600 hover:bg-slate-50 transition-colors group">
                        <span class="flex items-center gap-3">
                            <i class="fas fa-chart-line text-slate-400 text-xs w-4 text-center"></i>
                            New analysis
                        </span>
                        <i class="fas fa-chevron-right text-slate-300 text-[10px] group-hover:text-slate-500 transition-colors"></i>
                    </a>
                </div>
            </div>

            <div class="card p-5">
                <h2 class="text-sm font-semibold text-slate-900 mb-2">Export reports</h2>
                <p class="text-xs text-slate-400 mb-4">Download department data for review.</p>
                <div class="grid grid-cols-2 gap-2">
                    <button class="btn-secondary flex-col gap-1.5 py-3 text-xs">
                        <i class="fas fa-file-pdf text-red-400"></i>
                        PDF
                    </button>
                    <button class="btn-secondary flex-col gap-1.5 py-3 text-xs">
                        <i class="fas fa-file-excel text-emerald-500"></i>
                        Excel
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('stressDistChart').getContext('2d');
const high = {{ $highRiskCount }};
const total = {{ $totalStudents }};
const atRisk = Math.max(0, Math.round(total * 0.2));
const healthy = Math.max(0, total - high - atRisk);

new Chart(ctx,{
    type:'bar',
    data:{
        labels:['Healthy','At Risk','Struggling'],
        datasets:[{
            data:[healthy,atRisk,high],
            backgroundColor:['#f0fdf4','#fefce8','#fef2f2'],
            borderColor:['#86efac','#fde047','#fca5a5'],
            borderWidth:1.5,borderRadius:6,borderSkipped:false
        }]
    },
    options:{
        responsive:true,maintainAspectRatio:false,
        plugins:{legend:{display:false},
            tooltip:{backgroundColor:'#0f172a',titleColor:'#94a3b8',bodyColor:'#f1f5f9',
                     padding:10,cornerRadius:8,titleFont:{size:11},bodyFont:{size:12,weight:'600'}}},
        scales:{
            y:{beginAtZero:true,grid:{color:'#f1f5f9',drawBorder:false},border:{display:false},
               ticks:{color:'#94a3b8',font:{size:10},stepSize:1}},
            x:{grid:{display:false,drawBorder:false},border:{display:false},
               ticks:{color:'#64748b',font:{size:11}}}
        }
    }
});
</script>
@endsection
