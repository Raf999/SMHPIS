@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen bg-white">
    <!-- Left Side: Login Form -->
    <div class="w-full lg:w-1/2 flex flex-col justify-center items-center px-8 md:px-24">
        <div class="w-full max-w-md">
            <!-- Logo & Brand -->
            <div class="mb-12 flex flex-col items-center">
                <div class="h-16 w-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-500/30 mb-6">
                    <i class="fas fa-brain text-2xl"></i>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">SMHPIS Portal</h1>
                <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px] mt-2">Sign in to your account</p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-r-xl">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full h-14 px-6 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-blue-600 focus:bg-white outline-none transition-all font-bold text-slate-900">
                </div>

                <div>
                    <label for="password" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Password</label>
                    <input id="password" type="password" name="password" required
                           class="w-full h-14 px-6 bg-slate-50 rounded-2xl border-2 border-transparent focus:border-blue-600 focus:bg-white outline-none transition-all font-bold text-slate-900">
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                        <span class="ml-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="w-full h-16 bg-slate-900 text-white font-black rounded-2xl shadow-xl shadow-slate-900/20 hover:bg-blue-700 hover:scale-[1.02] active:scale-95 transition-all uppercase tracking-widest text-xs mt-8">
                    Sign In
                </button>
            </form>

            <div class="mt-12 text-center">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-blue-600 font-black hover:underline">Create one</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Right Side: Background Image & Quote -->
    <div class="hidden lg:block w-1/2 relative overflow-hidden">
        <img src="{{ asset('images/login_bg.png') }}" class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-blue-900/90 via-blue-900/20 to-transparent"></div>
        
        <div class="absolute bottom-20 left-20 right-20 text-white">
            <h2 class="text-5xl font-black leading-tight tracking-tighter mb-6">
                Understand your mind,<br>
                unlock your potential.
            </h2>
            <p class="text-blue-200 font-bold uppercase tracking-[0.3em] text-xs">SMHPIS AI Intelligence Dashboard</p>
        </div>
    </div>
</div>
@endsection
