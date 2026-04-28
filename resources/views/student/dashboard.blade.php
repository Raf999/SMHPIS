@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ explode(' ', Auth::user()->name)[0] }}</h1>
        <p class="page-subtitle">{{ now()->format('l, F j') }} · Personal Wellness Dashboard</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left 2/3 --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- KPI row --}}
            <div class="grid grid-cols-3 gap-4">

                <div class="stat-card">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs text-slate-500">Avg stress</p>
                        <div class="h-7 w-7 bg-blue-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-brain text-blue-600 text-[11px]"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-semibold text-slate-900">{{ number_format($avgStress,1) }}</p>
                    <p class="text-xs text-slate-400 mt-1">out of 10</p>
                </div>

                <div class="stat-card">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs text-slate-500">Avg sleep</p>
                        <div class="h-7 w-7 bg-indigo-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-moon text-indigo-600 text-[11px]"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-semibold text-slate-900">{{ number_format($avgSleep,1) }}<span class="text-base font-normal text-slate-400">h</span></p>
                    <p class="text-xs text-slate-400 mt-1">per night</p>
                </div>

                <div class="stat-card">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs text-slate-500">Check-ins</p>
                        <div class="h-7 w-7 bg-slate-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-slate-600 text-[11px]"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-semibold text-slate-900">{{ $totalPredictions }}</p>
                    <p class="text-xs text-slate-400 mt-1">total logged</p>
                </div>

            </div>

            {{-- Trend chart --}}
            <div class="card p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="text-sm font-semibold text-slate-900">Wellbeing Trend</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Score from recent check-ins</p>
                    </div>
                </div>
                @if($recentPredictions->isEmpty())
                <div class="h-44 flex flex-col items-center justify-center bg-slate-50 rounded-lg border border-dashed border-slate-200">
                    <i class="fas fa-chart-area text-slate-300 text-xl mb-2"></i>
                    <p class="text-xs text-slate-400">No data yet — complete your first check-in</p>
                </div>
                @else
                <div class="h-44">
                    <canvas id="wellbeingChart"></canvas>
                </div>
                @endif
            </div>

        </div>

        {{-- Right 1/3 --}}
        <div class="space-y-5">

            {{-- CTA --}}
            <div class="card p-6 bg-blue-600 border-blue-600 text-white">
                <div class="mb-5">
                    <h2 class="text-base font-semibold text-white">Start a check-in</h2>
                    <p class="text-sm text-blue-100 mt-1">Track your mental health with our AI analysis tool.</p>
                </div>
                <a href="{{ route('student.predict') }}"
                   class="inline-flex items-center gap-2 bg-white text-blue-700 text-sm font-medium rounded-lg px-4 py-2 hover:bg-blue-50 transition-colors">
                    <i class="fas fa-plus text-xs"></i>
                    New analysis
                </a>
            </div>

            {{-- Recent logs --}}
            <div class="card p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-slate-900">Recent logs</h2>
                    <a href="{{ route('predictions.index') }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium">View all</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentPredictions as $p)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 rounded-lg flex items-center justify-center shrink-0
                                {{ $p->prediction_result === 'Healthy' ? 'bg-green-50' : ($p->prediction_result === 'Struggling' ? 'bg-red-50' : 'bg-amber-50') }}">
                                <i class="fas text-xs
                                   {{ $p->prediction_result === 'Healthy' ? 'fa-check-circle text-green-600' : ($p->prediction_result === 'Struggling' ? 'fa-exclamation-circle text-red-500' : 'fa-info-circle text-amber-600') }}"></i>
                            </div>
                            <div>
                                @if($p->prediction_result === 'Healthy')
                                    <span class="badge-healthy">{{ $p->prediction_result }}</span>
                                @elseif($p->prediction_result === 'Struggling')
                                    <span class="badge-struggling">{{ $p->prediction_result }}</span>
                                @else
                                    <span class="badge-atrisk">{{ $p->prediction_result }}</span>
                                @endif
                                <p class="text-[11px] text-slate-400 mt-0.5">{{ $p->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="text-[11px] text-slate-400 bg-slate-50 px-2 py-0.5 rounded-md border border-slate-100">
                            #{{ $p->prediction_class }}
                        </span>
                    </div>
                    @empty
                    <div class="py-6 text-center">
                        <i class="fas fa-layer-group text-slate-200 text-lg mb-2"></i>
                        <p class="text-xs text-slate-400">No records yet</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

@if($recentPredictions->isNotEmpty())
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('wellbeingChart').getContext('2d');
const g = ctx.createLinearGradient(0,0,0,176);
g.addColorStop(0,'rgba(99,102,241,0.1)');
g.addColorStop(1,'rgba(99,102,241,0)');

const data = {{ Js::from($recentPredictions->map(function($p){ return ['label'=>$p->created_at->format('M j'),'score'=>(int)$p->prediction_class,'result'=>$p->prediction_result]; })->values()) }};

new Chart(ctx,{
    type:'line',
    data:{
        labels:data.map(p=>p.label),
        datasets:[{
            data:data.map(p=>p.score),
            borderColor:'#6366f1',borderWidth:2,fill:true,backgroundColor:g,tension:0.4,
            pointRadius:4,
            pointBackgroundColor:data.map(p=>p.result==='Healthy'?'#22c55e':p.result==='Struggling'?'#ef4444':'#f59e0b'),
            pointBorderColor:'#fff',pointBorderWidth:2,pointHoverRadius:6
        }]
    },
    options:{
        responsive:true,maintainAspectRatio:false,
        plugins:{legend:{display:false},
            tooltip:{backgroundColor:'#0f172a',titleColor:'#94a3b8',bodyColor:'#f1f5f9',padding:10,cornerRadius:8,
                titleFont:{size:11},bodyFont:{size:12,weight:'600'},
                callbacks:{label:(i)=>` Score: ${i.raw} — ${data[i.dataIndex].result}`}}},
        scales:{
            y:{beginAtZero:true,grid:{color:'#f1f5f9',drawBorder:false},border:{display:false},
               ticks:{color:'#94a3b8',font:{size:10},stepSize:1}},
            x:{grid:{display:false,drawBorder:false},border:{display:false},
               ticks:{color:'#64748b',font:{size:10}}}
        }
    }
});
</script>
@endif
@endsection
