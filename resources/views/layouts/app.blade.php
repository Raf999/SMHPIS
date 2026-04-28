<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SMHPIS Dashboard</title>

    <!-- Fonts: Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .icon-box {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: linear-gradient(310deg, #2563eb 0%, #9333ea 100%);
            color: white;
            font-size: 12px;
        }
        .sidebar-active {
            background-color: white !important;
            box-shadow: 0 20px 27px 0 rgba(0, 0, 0, 0.05);
            font-weight: 600;
        }
    </style>
</head>
<body class="font-sans antialiased bg-bg-soft min-h-screen text-slate-700">
    @auth
        @include('partials.sidebar')
    @endauth

    <div class="md:ml-64 transition-all duration-300">
        <!-- Top Bar for Mobile only -->
        <div class="md:hidden flex items-center justify-between p-4 bg-white/80 backdrop-blur-md sticky top-0 z-40 border-b border-slate-100">
            <span class="text-xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent uppercase tracking-tight">
                SMHPIS
            </span>
            <button id="mobile-toggle" class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Main Content Area -->
        <main class="p-4 md:p-10">
            @if (session('status'))
                <div class="max-w-7xl mx-auto mb-8">
                    <div class="bg-white border-l-4 border-primary text-slate-800 p-5 rounded-2xl shadow-soft flex items-center">
                        <div class="h-8 w-8 bg-blue-50 text-primary rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <span class="font-semibold">{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        document.getElementById('mobile-toggle')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>