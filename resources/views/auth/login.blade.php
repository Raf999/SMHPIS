@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex">

    {{-- Left: form --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-sm">

            {{-- Brand --}}
            <div class="mb-10">
                <div class="flex items-center gap-2.5 mb-6">
                    <div class="h-8 w-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-brain text-white text-xs"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-900">SMHPIS</span>
                </div>
                <h1 class="text-2xl font-semibold text-slate-900">Welcome back</h1>
                <p class="text-sm text-slate-500 mt-1">Sign in to your account to continue.</p>
            </div>

            {{-- Errors --}}
            @if($errors->any())
                <div class="alert-danger mb-6">
                    <i class="fas fa-exclamation-circle text-red-500 text-sm shrink-0 mt-0.5"></i>
                    <ul class="text-sm text-red-700 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="form-label">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="email"
                           class="form-input" placeholder="you@university.edu">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="form-label mb-0">Password</label>
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium">Forgot password?</a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required
                           class="form-input" placeholder="••••••••">
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                           class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <label for="remember" class="text-sm text-slate-600">Remember me</label>
                </div>

                <button type="submit" class="btn-primary w-full h-10 mt-2">
                    Sign in
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-slate-500">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-medium">Create one</a>
            </p>

        </div>
    </div>

    {{-- Right: illustration panel --}}
    <div class="hidden lg:flex lg:w-1/2 bg-slate-900 items-end p-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('{{ asset('images/login_bg.png') }}')] bg-cover bg-center opacity-20"></div>
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 rounded-lg mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                <span class="text-xs font-medium text-white/80">AI-Powered Wellness Platform</span>
            </div>
            <h2 class="text-4xl font-semibold text-white leading-tight mb-4">
                Understand your mind,<br>unlock your potential.
            </h2>
            <p class="text-slate-400 text-sm">Student Mental Health Prediction & Information System</p>
        </div>
    </div>

</div>
@endsection
