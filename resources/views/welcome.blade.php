<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMHPIS | Student Mental Health Prediction</title>
    
    <!-- Fonts: Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .bg-pattern {
            background-image: radial-gradient(#e2e8f0 0.8px, transparent 0.8px);
            background-size: 24px 24px;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        .float-animation { animation: float 6s ease-in-out infinite; }
    </style>
</head>
<body class="bg-bg-soft bg-pattern font-sans antialiased text-slate-900">

    <!-- NAVBAR -->
    <nav class="fixed top-0 w-full z-50 glass-card rounded-none border-t-0 border-x-0">
        <div class="max-w-7xl mx-auto px-6 h-18 flex items-center justify-between py-4">
            <div class="flex items-center space-x-3">
                <div class="h-9 w-9 hero-gradient rounded-lg flex items-center justify-center text-white shadow-md">
                    <i class="fas fa-shield-heart"></i>
                </div>
                <span class="text-lg font-bold tracking-tight text-slate-900 uppercase">SMHPIS</span>
            </div>
            
            <div class="flex items-center space-x-6">
                <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-widest text-slate-500 hover:text-primary transition-colors">Login</a>
                <a href="#" class="btn-primary py-2 px-5 !text-[10px]">Enroll Your School</a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="pt-44 pb-24 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                <!-- Text Content -->
                <div class="lg:w-1/2 text-left">
                    <div class="badge-blue mb-8 inline-flex items-center space-x-2">
                        <i class="fas fa-circle-check"></i>
                        <span>Smart Mental Health Detection</span>
                    </div>
                    
                    <h1 class="text-5xl md:text-6xl font-black text-slate-900 leading-tight tracking-tight mb-8">
                        Student <span class="text-transparent bg-clip-text hero-gradient">Mental Health</span><br>
                        Prediction & Support
                    </h1>
                    
                    <p class="text-lg text-slate-600 max-w-xl mb-12 font-medium leading-relaxed">
                        A professional diagnostic system designed to identify and support students in need through intelligent data analysis and personalized AI guidance.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
                        <a href="#" class="btn-primary w-full sm:w-auto px-10">
                            Enroll Your School
                        </a>
                        <a href="#problem" class="btn-outline w-full sm:w-auto px-10">
                            View Methodology
                        </a>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="lg:w-1/2 relative">
                    <div class="absolute inset-0 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse"></div>
                    <img src="{{ asset('images/hero.png') }}" alt="Student Mental Health Support" class="relative z-10 w-full max-w-[650px] mx-auto float-animation rounded-4xl shadow-2xl border-8 border-white/50">
                </div>
            </div>
            
            <p class="mt-20 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] text-center lg:text-left">
                Accra Technical University <span class="mx-2">•</span> BTECH Project
            </p>
        </div>
    </section>

    <!-- PROBLEM SECTION -->
    <section id="problem" class="py-24 bg-white border-y border-slate-100">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-xs font-bold text-primary uppercase tracking-[0.2em] mb-6">The Context</h2>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight mb-8">Addressing Modern Academic Stress</h3>
            <p class="text-lg text-slate-600 font-medium leading-relaxed">
                Student mental health issues such as stress, anxiety, and depression are increasing globally. 
                Traditional systems often fail to detect problems early, leaving many students without timely support. 
                SMHPIS provides the technological bridge for proactive wellness management.
            </p>
        </div>
    </section>

    <!-- SOLUTION SECTION -->
    <section class="py-24 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-xs font-bold text-secondary uppercase tracking-[0.2em] mb-4">Core Framework</h2>
                <h3 class="text-3xl font-black text-slate-900 tracking-tight">Our Systematic Approach</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Step 1 -->
                <div class="card-soft p-10">
                    <div class="h-14 w-14 bg-blue-50 text-primary rounded-xl flex items-center justify-center text-xl mb-8">
                        <i class="fas fa-database"></i>
                    </div>
                    <h4 class="text-md font-bold text-slate-900 mb-4 uppercase tracking-tight">1. Data Ingestion</h4>
                    <p class="text-sm text-slate-600 font-medium leading-relaxed">Collection of relevant academic and emotional indicators through secure, anonymized forms.</p>
                </div>
                
                <!-- Step 2 -->
                <div class="card-soft p-10">
                    <div class="h-14 w-14 bg-purple-50 text-secondary rounded-xl flex items-center justify-center text-xl mb-8">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h4 class="text-md font-bold text-slate-900 mb-4 uppercase tracking-tight">2. Neural Analysis</h4>
                    <p class="text-sm text-slate-600 font-medium leading-relaxed">Validation through machine learning models to identify risk patterns with professional accuracy.</p>
                </div>
                
                <!-- Step 3 -->
                <div class="card-soft p-10">
                    <div class="h-14 w-14 bg-slate-50 text-slate-900 rounded-xl flex items-center justify-center text-xl mb-8">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h4 class="text-md font-bold text-slate-900 mb-4 uppercase tracking-tight">3. Intervention</h4>
                    <p class="text-sm text-slate-600 font-medium leading-relaxed">Generation of immediate, actionable recommendations to support student well-being.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="py-24 bg-slate-900 text-white relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-xs font-bold text-blue-400 uppercase tracking-[0.2em] mb-4">System Features</h2>
                <h3 class="text-3xl font-black tracking-tight text-white">Functional Capabilities</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $features = [
                        ['icon' => 'fa-bolt', 'title' => 'Real-time Predictions', 'desc' => 'Instant analysis using trained ML models for immediate results.'],
                        ['icon' => 'fa-chart-pie', 'title' => 'Diagnostic Insights', 'desc' => 'Comprehensive data visualization for institutional decision support.'],
                        ['icon' => 'fa-user-shield', 'title' => 'Role Security', 'desc' => 'Segmented access controls for Admins, Teachers, and Students.'],
                        ['icon' => 'fa-lock', 'title' => 'Data Privacy', 'desc' => 'Encryption-based protection for all personal and academic data.'],
                        ['icon' => 'fa-history', 'title' => 'System Logs', 'desc' => 'Complete audit trails and historical prediction archives.'],
                        ['icon' => 'fa-gears', 'title' => 'Scalable Design', 'desc' => 'Engineered for seamless performance across multiple departments.'],
                    ];
                @endphp

                @foreach($features as $feature)
                    <div class="p-8 bg-white/5 border border-white/10 rounded-2xl hover:bg-white/10 transition-colors group">
                        <i class="fas {{ $feature['icon'] }} text-blue-400 text-xl mb-6 group-hover:scale-110 transition-transform"></i>
                        <h4 class="text-sm font-bold uppercase tracking-widest mb-3 text-white">{{ $feature['title'] }}</h4>
                        <p class="text-xs text-slate-400 font-medium leading-relaxed">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="py-16 bg-white border-t border-slate-100 text-center">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-center space-x-2 mb-8 opacity-50">
                <div class="h-6 w-6 hero-gradient rounded flex items-center justify-center text-white text-[10px]">
                    <i class="fas fa-shield-heart"></i>
                </div>
                <span class="text-sm font-bold tracking-tight text-slate-900 uppercase">SMHPIS</span>
            </div>
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-6 leading-loose">
                BTECH Computer Science Project <br>
                Accra Technical University
            </p>
            <div class="w-12 h-px bg-slate-200 mx-auto mb-6"></div>
            <p class="text-[10px] font-medium text-slate-300 uppercase tracking-[0.3em]">
                © {{ date('Y') }} SMHPIS System
            </p>
        </div>
    </footer>

</body>
</html>
