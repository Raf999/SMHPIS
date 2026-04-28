@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <nav class="flex text-xs font-bold text-slate-400 uppercase tracking-widest mb-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li>Pages</li>
                <li><span class="mx-2 text-slate-300">/</span></li>
                <li class="text-slate-900">Personal Dashboard</li>
            </ol>
        </nav>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Welcome back, {{ Auth::user()->name }}!</h1>
        <p class="text-slate-400 text-sm font-medium">Tracking your wellbeing and academic success.</p>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Columns -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Stats Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card-soft p-5 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Avg Stress</p>
                        <h3 class="text-xl font-black text-slate-900">{{ number_format($avgStress, 1) }}</h3>
                    </div>
                    <div class="h-10 w-10 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                        <i class="fas fa-brain text-xs"></i>
                    </div>
                </div>
                <div class="card-soft p-5 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Avg Sleep</p>
                        <h3 class="text-xl font-black text-slate-900">{{ number_format($avgSleep, 1) }}h</h3>
                    </div>
                    <div class="h-10 w-10 bg-secondary rounded-xl flex items-center justify-center text-white shadow-lg shadow-purple-500/20">
                        <i class="fas fa-moon text-xs"></i>
                    </div>
                </div>
                <div class="card-soft p-5 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Logs</p>
                        <h3 class="text-xl font-black text-slate-900">{{ $totalPredictions }}</h3>
                    </div>
                    <div class="h-10 w-10 bg-slate-800 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-clipboard-list text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Activity Chart Section -->
            <div class="card-soft p-8">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-lg font-black text-slate-900 tracking-tight">Wellbeing Activity</h3>
                    <div class="px-4 py-2 bg-slate-50 rounded-xl text-[10px] font-black text-slate-400 border border-slate-100 uppercase tracking-widest cursor-pointer hover:bg-slate-100 transition-colors">
                        This Week <i class="fas fa-chevron-down ml-2"></i>
                    </div>
                </div>
                <div class="h-64 flex flex-col items-center justify-center bg-slate-50/50 rounded-2xl border-2 border-dashed border-slate-100 relative overflow-hidden group">
                    <div class="absolute inset-x-0 bottom-0 flex items-end justify-around px-8 pb-8 h-full opacity-30">
                        <div class="w-6 bg-primary rounded-t-lg h-20"></div>
                        <div class="w-6 bg-secondary rounded-t-lg h-32"></div>
                        <div class="w-6 bg-primary rounded-t-lg h-16"></div>
                        <div class="w-6 bg-secondary rounded-t-lg h-40"></div>
                        <div class="w-6 bg-primary rounded-t-lg h-24"></div>
                    </div>
                    <div class="relative z-10 text-center">
                        <div class="h-12 w-12 bg-white rounded-xl shadow-soft flex items-center justify-center text-primary mb-4 mx-auto group-hover:scale-110 transition-transform">
                            <i class="fas fa-chart-area"></i>
                        </div>
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Trend visualization processing</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-8">
            <!-- CTA Card -->
            <div class="bg-gradient-to-br from-primary to-secondary p-8 rounded-[2rem] shadow-xl relative overflow-hidden group min-h-[300px] flex flex-col justify-between">
                <div class="absolute inset-0 bg-pattern opacity-10"></div>
                <div class="relative z-10">
                    <h3 class="text-2xl font-black text-white leading-tight mb-2">Monitor Your <br> Progress</h3>
                    <p class="text-white/70 text-[10px] font-black uppercase tracking-widest">AI Mental Health Check</p>
                </div>
                
                <div class="relative z-10 mt-8">
                    <a href="{{ route('student.predict') }}" class="inline-flex items-center justify-center h-12 w-12 bg-white text-primary rounded-xl shadow-lg hover:scale-110 transition-transform active:scale-95">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>

                <div class="absolute -bottom-6 -right-6 opacity-20">
                    <div class="h-32 w-32 rounded-full border-[12px] border-white"></div>
                </div>
            </div>

            <!-- Recent Reports -->
            <div class="card-soft p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-black text-slate-900 tracking-tight">Recent Logs</h3>
                    <a href="{{ route('predictions.index') }}" class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline">View All</a>
                </div>
                <div class="space-y-6">
                    @forelse($recentPredictions as $p)
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center">
                                <div class="h-12 w-12 rounded-xl flex items-center justify-center text-xl transition-transform group-hover:scale-110 {{ $p->prediction_result == 'Healthy' ? 'bg-blue-50 text-primary' : ($p->prediction_result == 'Struggling' ? 'bg-red-50 text-red-500' : 'bg-purple-50 text-secondary') }}">
                                    <i class="fas {{ $p->prediction_result == 'Healthy' ? 'fa-check-circle' : ($p->prediction_result == 'Struggling' ? 'fa-exclamation-circle' : 'fa-info-circle') }}"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-xs font-black text-slate-900 uppercase tracking-tight">{{ $p->prediction_result }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $p->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="h-6 w-6 rounded-full bg-slate-50 flex items-center justify-center text-[8px] font-black text-slate-400">
                                #{{ $p->prediction_class }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <i class="fas fa-layer-group text-2xl text-slate-100 mb-3"></i>
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest leading-relaxed">No wellness records <br> found yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
