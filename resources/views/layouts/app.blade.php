<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SMHPIS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 min-h-screen">

    @auth
        @include('partials.sidebar')
    @endauth

    <div class="md:ml-60 transition-all duration-300 min-h-screen flex flex-col">
        {{-- Mobile top bar --}}
        <div class="md:hidden flex items-center justify-between h-14 px-4 bg-white border-b border-slate-200 sticky top-0 z-40">
            <span class="text-sm font-semibold text-slate-900">SMHPIS</span>
            <button id="mobile-toggle" class="p-2 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors">
                <i class="fas fa-bars text-sm"></i>
            </button>
        </div>

        <main class="flex-1 p-4 md:p-8">
            @if(session('status'))
                <div class="max-w-7xl mx-auto mb-6">
                    <div class="alert-success">
                        <i class="fas fa-check-circle text-green-600 text-sm shrink-0 mt-0.5"></i>
                        <span class="text-sm text-green-800">{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="max-w-7xl mx-auto mb-6">
                    <div class="alert-danger">
                        <i class="fas fa-exclamation-circle text-red-600 text-sm shrink-0 mt-0.5"></i>
                        <span class="text-sm text-red-800">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        document.getElementById('mobile-toggle')?.addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>
