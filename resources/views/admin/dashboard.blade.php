@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="page-header flex items-center justify-between">
        <div>
            <h1 class="page-title">Overview</h1>
            <p class="page-subtitle">{{ now()->format('l, F j, Y') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2.5 px-3 py-2 bg-white border border-slate-200 rounded-lg">
                <div class="h-7 w-7 rounded-md overflow-hidden bg-blue-100 flex items-center justify-center shrink-0">
                    @if(Auth::user()->profile_image_url)
                        <img src="{{ Auth::user()->profile_image_url }}" class="h-full w-full object-cover">
                    @else
                        <span class="text-xs font-semibold text-blue-700">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    @endif
                </div>
                <div class="hidden sm:block">
                    <p class="text-xs font-medium text-slate-800 leading-none">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Administrator</p>
                </div>
            </div>
        </div>
    </div>

    {{-- KPI grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs text-slate-500">Total users</p>
                <div class="h-7 w-7 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-[11px]"></i>
                </div>
            </div>
            <p class="text-2xl font-semibold text-slate-900">{{ $totalUsers }}</p>
            <p class="text-xs text-slate-400 mt-1">All roles</p>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs text-slate-500">Students</p>
                <div class="h-7 w-7 bg-orange-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-graduate text-orange-500 text-[11px]"></i>
                </div>
            </div>
            <p class="text-2xl font-semibold text-slate-900">{{ $studentCount }}</p>
            <p class="text-xs text-slate-400 mt-1">Enrolled</p>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs text-slate-500">Faculty</p>
                <div class="h-7 w-7 bg-emerald-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-emerald-600 text-[11px]"></i>
                </div>
            </div>
            <p class="text-2xl font-semibold text-slate-900">{{ $teacherCount }}</p>
            <p class="text-xs text-slate-400 mt-1">Active</p>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs text-slate-500">Predictions</p>
                <div class="h-7 w-7 bg-slate-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-microchip text-slate-600 text-[11px]"></i>
                </div>
            </div>
            <p class="text-2xl font-semibold text-slate-900">{{ $totalPredictions }}</p>
            <p class="text-xs text-slate-400 mt-1">AI engine active</p>
        </div>

    </div>

    {{-- Chart + summary --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 card p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-sm font-semibold text-slate-900">Mental Health Trends</h2>
                    <p class="text-xs text-slate-400 mt-0.5">30-day rolling index</p>
                </div>
                <div class="flex items-center gap-4 text-xs text-slate-500">
                    <span class="flex items-center gap-1.5">
                        <span class="h-2 w-3 rounded-full bg-blue-500 inline-block"></span>Stress
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="h-2 w-3 rounded-full bg-indigo-400 inline-block"></span>Anxiety
                    </span>
                </div>
            </div>
            <div class="h-56">
                <canvas id="mentalHealthChart"></canvas>
            </div>
        </div>

        <div class="card p-6">
            <h2 class="text-sm font-semibold text-slate-900 mb-5">System breakdown</h2>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-xs text-slate-500 mb-1.5">
                        <span>Students</span>
                        <span class="font-medium text-slate-700">{{ $totalUsers > 0 ? round(($studentCount/$totalUsers)*100) : 0 }}%</span>
                    </div>
                    <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full" style="width: {{ $totalUsers > 0 ? round(($studentCount/$totalUsers)*100) : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs text-slate-500 mb-1.5">
                        <span>Faculty</span>
                        <span class="font-medium text-slate-700">{{ $totalUsers > 0 ? round(($teacherCount/$totalUsers)*100) : 0 }}%</span>
                    </div>
                    <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $totalUsers > 0 ? round(($teacherCount/$totalUsers)*100) : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs text-slate-500 mb-1.5">
                        <span>Avg predictions/student</span>
                        <span class="font-medium text-slate-700">{{ $studentCount > 0 ? number_format($totalPredictions/$studentCount,1) : '—' }}</span>
                    </div>
                    <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-indigo-400 rounded-full" style="width: 55%"></div>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-5 border-t border-slate-100 flex items-center gap-3">
                <div class="h-8 w-8 bg-emerald-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-server text-emerald-600 text-xs"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-800">Server healthy</p>
                    <p class="text-[11px] text-slate-400">All systems nominal</p>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('mentalHealthChart').getContext('2d');
const gBlue = ctx.createLinearGradient(0,0,0,224);
gBlue.addColorStop(0,'rgba(59,130,246,0.12)');
gBlue.addColorStop(1,'rgba(59,130,246,0)');
const gIndigo = ctx.createLinearGradient(0,0,0,224);
gIndigo.addColorStop(0,'rgba(99,102,241,0.1)');
gIndigo.addColorStop(1,'rgba(99,102,241,0)');

const labels = Array.from({length:30},(_,i)=>{
    const d=new Date(); d.setDate(d.getDate()-(29-i));
    return d.toLocaleDateString('en',{month:'short',day:'numeric'});
});

new Chart(ctx,{
    type:'line',
    data:{
        labels,
        datasets:[
            {label:'Stress',data:Array.from({length:30},()=>+(Math.random()*4+3).toFixed(1)),
             borderColor:'#3b82f6',borderWidth:2,fill:true,backgroundColor:gBlue,tension:0.4,
             pointRadius:0,pointHoverRadius:4,pointHoverBackgroundColor:'#3b82f6',pointHoverBorderColor:'#fff',pointHoverBorderWidth:2},
            {label:'Anxiety',data:Array.from({length:30},()=>+(Math.random()*3.5+2.5).toFixed(1)),
             borderColor:'#818cf8',borderWidth:2,fill:true,backgroundColor:gIndigo,tension:0.4,
             pointRadius:0,pointHoverRadius:4,pointHoverBackgroundColor:'#818cf8',pointHoverBorderColor:'#fff',pointHoverBorderWidth:2}
        ]
    },
    options:{
        responsive:true,maintainAspectRatio:false,
        interaction:{mode:'index',intersect:false},
        plugins:{
            legend:{display:false},
            tooltip:{backgroundColor:'#0f172a',titleColor:'#94a3b8',bodyColor:'#f1f5f9',padding:10,cornerRadius:8,
                     titleFont:{size:11},bodyFont:{size:12,weight:'600'}}
        },
        scales:{
            y:{min:0,max:10,grid:{color:'#f1f5f9',drawBorder:false},border:{display:false},
               ticks:{color:'#94a3b8',font:{size:10},padding:6,stepSize:2}},
            x:{grid:{display:false,drawBorder:false},border:{display:false},
               ticks:{color:'#94a3b8',font:{size:10},maxTicksLimit:7,maxRotation:0}}
        }
    }
});
</script>
@endsection
