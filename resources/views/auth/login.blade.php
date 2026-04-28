@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-bg-soft bg-pattern flex items-center justify-center relative overflow-hidden p-6">
    <!-- Decorative background elements -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>

    <div class="relative z-10 w-full max-w-[1100px] glass-card !rounded-[3rem] flex overflow-hidden !p-0">
        <!-- Left Side: Visual -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-primary to-secondary items-center justify-center p-12 text-white overflow-hidden">
            <div class="absolute inset-0 bg-pattern opacity-10"></div>
            <div class="relative z-10 text-center animate-fade-in-up">
                <div class="mb-8 inline-flex items-center justify-center p-5 bg-white/20 backdrop-blur-md rounded-3xl border border-white/30">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h1 class="text-5xl font-black mb-6 tracking-tight uppercase">SMHPIS</h1>
                <p class="text-xl font-medium opacity-90 max-w-md mx-auto leading-relaxed">Empowering student success through intelligent mental health support.</p>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="flex-1 p-12 sm:p-20 flex flex-col justify-center bg-white/40">
            <div class="mb-10">
                <a href="/" class="inline-flex items-center text-xs font-black uppercase tracking-widest text-slate-400 hover:text-primary transition-colors mb-8 group">
                    <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                    Back to Home
                </a>
                <h2 class="text-4xl font-black text-slate-900 mb-2 tracking-tight">Welcome Back</h2>
                <p class="text-slate-500 font-medium">Please sign in to access your dashboard.</p>
            </div>

            @if($errors->any() || session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-5 rounded-2xl mb-8 animate-shake">
                    <p class="text-sm font-bold">{{ $errors->first() ?? session('error') }}</p>
                </div>
            @endif

            <form method="POST" action="/login" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Email Address</label>
                    <input id="email" type="email" name="email" required autofocus
                           class="input-standard h-14 !px-6"
                           placeholder="john@university.edu">
                </div>

                <div>
                    <label for="password" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Password</label>
                    <input id="password" type="password" name="password" required
                           class="input-standard h-14 !px-6"
                           placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between pb-4">
                    <label class="flex items-center text-xs font-bold text-slate-400 cursor-pointer hover:text-slate-600 transition-colors">
                        <input type="checkbox" name="remember" class="mr-3 h-5 w-5 rounded-lg border-2 border-slate-200 text-primary focus:ring-0">
                        Remember Session
                    </label>
                </div>

                <button type="submit" class="btn-primary w-full h-16 !text-xs">
                    Access Dashboard
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    .animate-shake {
        animation: shake 0.4s ease-in-out;
    }
</style>
@endsection
