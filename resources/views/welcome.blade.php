<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SMHPIS — A professional AI-powered system to support student mental health through early detection and personalized guidance.">
    <title>SMHPIS | Student Mental Health Prediction & Support</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Lora:wght@400;500&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <style>
        /* ---- Welcome page scoped styles ---- */
        .welcome-body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fb;
            color: #374151;
        }

        /* Navbar */
        .wl-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid #eef0f4;
        }
        .wl-nav-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .wl-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .wl-logo-icon {
            width: 34px;
            height: 34px;
            background: #eff6ff;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 15px;
        }
        .wl-logo-text {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            letter-spacing: 0.04em;
        }
        .wl-nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
        }
        .wl-nav-link {
            font-size: 13px;
            font-weight: 400;
            color: #6b7280;
            text-decoration: none;
            transition: color 0.2s;
        }
        .wl-nav-link:hover { color: #111827; }
        .wl-btn-login {
            font-size: 13px;
            font-weight: 500;
            color: #2563eb;
            text-decoration: none;
            border: 1px solid #dbeafe;
            padding: 7px 18px;
            border-radius: 8px;
            background: #eff6ff;
            transition: background 0.2s, border-color 0.2s;
        }
        .wl-btn-login:hover {
            background: #dbeafe;
            border-color: #bfdbfe;
        }

        /* Hero */
        .wl-hero {
            padding-top: 140px;
            padding-bottom: 96px;
            max-width: 1100px;
            margin: 0 auto;
            padding-left: 24px;
            padding-right: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 48px;
        }
        .wl-hero-content {
            flex: 1;
            min-width: 0;
        }
        .wl-hero-image-wrap {
            flex: 0 0 420px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .wl-hero-glow {
            position: absolute;
            inset: -40px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59,130,246,0.10) 0%, transparent 70%);
            pointer-events: none;
        }
        .wl-hero-image {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 400px;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.10), 0 4px 16px rgba(59,130,246,0.08);
            border: 6px solid rgba(255,255,255,0.85);
        }
        /* Floating badge on image */
        .wl-image-badge {
            position: absolute;
            z-index: 3;
            background: white;
            border: 1px solid #eef0f4;
            border-radius: 12px;
            padding: 10px 14px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .wl-image-badge-top {
            top: -18px;
            right: 24px;
        }
        .wl-image-badge-bottom {
            bottom: -18px;
            left: 24px;
        }
        .wl-image-badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
            flex-shrink: 0;
        }
        .wl-image-badge-dot-blue {
            background: #3b82f6;
        }
        .wl-image-badge-text {
            font-size: 11px;
            font-weight: 500;
            color: #374151;
            white-space: nowrap;
        }
        /* Floating animation */
        @keyframes wl-float {
            0%   { transform: translateY(0px);    }
            50%  { transform: translateY(-14px);  }
            100% { transform: translateY(0px);    }
        }
        .wl-float { animation: wl-float 7s ease-in-out infinite; }

        /* Subtle dot pattern */
        .wl-dotgrid {
            background-image: radial-gradient(circle, #d1d5db 1px, transparent 1px);
            background-size: 28px 28px;
        }

        .wl-hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 11px;
            font-weight: 500;
            color: #2563eb;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 99px;
            padding: 5px 14px;
            margin-bottom: 28px;
        }
        .wl-hero-title {
            font-family: 'Lora', Georgia, serif;
            font-size: clamp(34px, 5vw, 54px);
            font-weight: 500;
            color: #111827;
            line-height: 1.25;
            letter-spacing: -0.02em;
            margin-bottom: 20px;
            max-width: 620px;
        }
        .wl-hero-title span {
            color: #2563eb;
        }
        .wl-hero-sub {
            font-size: 16px;
            font-weight: 400;
            color: #6b7280;
            line-height: 1.75;
            max-width: 500px;
            margin-bottom: 40px;
        }
        .wl-hero-actions {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }
        .wl-cta-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #2563eb;
            color: white;
            font-size: 13px;
            font-weight: 500;
            padding: 11px 24px;
            border-radius: 9px;
            text-decoration: none;
            transition: background 0.2s;
        }
        .wl-cta-primary:hover { background: #1d4ed8; }
        .wl-cta-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #374151;
            font-size: 13px;
            font-weight: 500;
            padding: 11px 20px;
            border-radius: 9px;
            text-decoration: none;
            border: 1px solid #e5e7eb;
            background: white;
            transition: border-color 0.2s, background 0.2s;
        }
        .wl-cta-secondary:hover { border-color: #d1d5db; background: #f9fafb; }
        .wl-hero-note {
            margin-top: 48px;
            font-size: 11px;
            color: #9ca3af;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        @media (max-width: 900px) {
            .wl-hero {
                flex-direction: column;
                padding-top: 120px;
                padding-bottom: 64px;
            }
            .wl-hero-image-wrap {
                flex: none;
                width: 100%;
                max-width: 340px;
                margin: 0 auto;
            }
        }

        /* Divider */
        .wl-divider {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
            border: none;
            border-top: 1px solid #f0f1f4;
        }

        /* Stats bar */
        .wl-stats {
            background: white;
            border-top: 1px solid #f0f1f4;
            border-bottom: 1px solid #f0f1f4;
        }
        .wl-stats-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 36px 24px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
        }
        .wl-stat {
            padding: 0 32px;
            border-right: 1px solid #f0f1f4;
        }
        .wl-stat:first-child { padding-left: 0; }
        .wl-stat:last-child { border-right: none; }
        .wl-stat-value {
            font-family: 'Lora', serif;
            font-size: 28px;
            font-weight: 500;
            color: #111827;
            line-height: 1;
            margin-bottom: 6px;
        }
        .wl-stat-label {
            font-size: 12px;
            color: #9ca3af;
            font-weight: 400;
        }

        /* Section */
        .wl-section {
            max-width: 1100px;
            margin: 0 auto;
            padding: 88px 24px;
        }
        .wl-section-label {
            font-size: 11px;
            font-weight: 500;
            color: #9ca3af;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 12px;
        }
        .wl-section-title {
            font-family: 'Lora', Georgia, serif;
            font-size: clamp(22px, 3vw, 32px);
            font-weight: 500;
            color: #111827;
            line-height: 1.3;
            letter-spacing: -0.01em;
            margin-bottom: 16px;
        }
        .wl-section-body {
            font-size: 15px;
            color: #6b7280;
            line-height: 1.8;
            max-width: 560px;
        }

        /* 3-step cards */
        .wl-steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-top: 48px;
        }
        .wl-step-card {
            background: white;
            border: 1px solid #eef0f4;
            border-radius: 16px;
            padding: 32px 28px;
            transition: box-shadow 0.2s;
        }
        .wl-step-card:hover {
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }
        .wl-step-num {
            font-size: 10px;
            font-weight: 500;
            color: #9ca3af;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 16px;
        }
        .wl-step-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #374151;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .wl-step-title {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 10px;
        }
        .wl-step-desc {
            font-size: 13px;
            color: #9ca3af;
            line-height: 1.7;
        }

        /* Features dark section */
        .wl-features-bg {
            background: #111827;
        }
        .wl-features-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 88px 24px;
        }
        .wl-features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
            background: #1e2737;
            border: 1px solid #1e2737;
            border-radius: 16px;
            overflow: hidden;
            margin-top: 48px;
        }
        .wl-feature-item {
            background: #111827;
            padding: 32px 28px;
            transition: background 0.2s;
        }
        .wl-feature-item:hover { background: #1a2333; }
        .wl-feature-icon {
            width: 36px;
            height: 36px;
            background: #1e2737;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 14px;
            margin-bottom: 18px;
        }
        .wl-feature-title {
            font-size: 13px;
            font-weight: 500;
            color: #f3f4f6;
            margin-bottom: 8px;
        }
        .wl-feature-desc {
            font-size: 12px;
            color: #6b7280;
            line-height: 1.7;
        }

        /* Footer */
        .wl-footer {
            background: white;
            border-top: 1px solid #f0f1f4;
            padding: 48px 24px;
            text-align: center;
        }
        .wl-footer-logo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }
        .wl-footer-logo-icon {
            width: 28px;
            height: 28px;
            background: #eff6ff;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3b82f6;
            font-size: 12px;
        }
        .wl-footer-logo-text {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            letter-spacing: 0.04em;
        }
        .wl-footer-school {
            font-size: 12px;
            color: #9ca3af;
            margin-bottom: 24px;
        }
        .wl-footer-divider {
            width: 32px;
            height: 1px;
            background: #e5e7eb;
            margin: 0 auto 20px;
        }
        .wl-footer-copy {
            font-size: 11px;
            color: #d1d5db;
            letter-spacing: 0.06em;
        }

        @media (max-width: 768px) {
            .wl-steps { grid-template-columns: 1fr; }
            .wl-features-grid { grid-template-columns: 1fr; }
            .wl-stats-inner { grid-template-columns: 1fr; gap: 24px; }
            .wl-stat { border-right: none; padding-left: 0; border-bottom: 1px solid #f0f1f4; padding-bottom: 24px; }
            .wl-stat:last-child { border-bottom: none; }
            .wl-nav-links .wl-nav-link { display: none; }
        }
    </style>
</head>
<body class="welcome-body">

    <!-- NAVBAR -->
    <nav class="wl-nav">
        <div class="wl-nav-inner">
            <a href="#" class="wl-logo">
                <img src="{{ asset('images/logo.png') }}" alt="SMHPIS Logo" class="wl-logo-icon" style="background: none; object-fit: contain;">
                <span class="wl-logo-text">SMHPIS</span>
            </a>
            <div class="wl-nav-links">
                <a href="#approach" class="wl-nav-link">Approach</a>
                <a href="#features" class="wl-nav-link">Features</a>
                <a href="{{ route('login') }}" class="wl-btn-login">Sign In</a>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section style="background-color: #f8f9fb;">
        <div class="wl-hero">
            <!-- Text -->
            <div class="wl-hero-content">
                <div class="wl-hero-eyebrow">
                    <i class="fas fa-circle" style="font-size:6px;"></i>
                    AI-Powered Mental Health Detection
                </div>

                <h1 class="wl-hero-title">
                    Supporting student<br>
                    <span>mental wellbeing</span><br>
                    through intelligent care
                </h1>

                <p class="wl-hero-sub">
                    SMHPIS uses machine learning to help schools detect mental health risks early and provide students with timely, personalized support.
                </p>

                <div class="wl-hero-actions">
                    <a href="#" class="wl-cta-primary">
                        Enroll Your School
                        <i class="fas fa-arrow-right" style="font-size:11px;"></i>
                    </a>
                    <a href="#approach" class="wl-cta-secondary">
                        How it works
                    </a>
                </div>

                <p class="wl-hero-note">
                    Accra Technical University &nbsp;&middot;&nbsp; BTECH Final Year Project
                </p>
            </div>

            <!-- Animated Image -->
            <div class="wl-hero-image-wrap wl-float">
                <div class="wl-hero-glow"></div>

                <!-- Top floating badge -->
                <div class="wl-image-badge wl-image-badge-top">
                    <span class="wl-image-badge-dot"></span>
                    <span class="wl-image-badge-text">Prediction Active</span>
                </div>

                <img
                    src="{{ asset('images/hero.png') }}"
                    alt="Student Mental Health Support"
                    class="wl-hero-image"
                >

                <!-- Bottom floating badge -->
                <div class="wl-image-badge wl-image-badge-bottom">
                    <span class="wl-image-badge-dot wl-image-badge-dot-blue"></span>
                    <span class="wl-image-badge-text">AI Advice Generated</span>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS BAR -->
    <div class="wl-stats">
        <div class="wl-stats-inner">
            <div class="wl-stat">
                <div class="wl-stat-value">3</div>
                <div class="wl-stat-label">Risk categories identified</div>
            </div>
            <div class="wl-stat">
                <div class="wl-stat-value">ML</div>
                <div class="wl-stat-label">Stacked model ensemble</div>
            </div>
            <div class="wl-stat">
                <div class="wl-stat-value">AI</div>
                <div class="wl-stat-label">Gemini-powered advice</div>
            </div>
        </div>
    </div>

    <!-- APPROACH SECTION -->
    <section id="approach">
        <div class="wl-section">
            <p class="wl-section-label">Our Approach</p>
            <h2 class="wl-section-title">Built on a systematic,<br>evidence-based framework</h2>
            <p class="wl-section-body">
                Traditional systems wait for students to seek help. SMHPIS flips that model by proactively analyzing academic and emotional indicators to surface those who need support before it becomes a crisis.
            </p>

            <div class="wl-steps">
                <div class="wl-step-card">
                    <p class="wl-step-num">Step 01</p>
                    <div class="wl-step-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3 class="wl-step-title">Data Collection</h3>
                    <p class="wl-step-desc">Students submit anonymized academic and emotional indicators through a structured, secure form.</p>
                </div>
                <div class="wl-step-card">
                    <p class="wl-step-num">Step 02</p>
                    <div class="wl-step-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3 class="wl-step-title">ML Analysis</h3>
                    <p class="wl-step-desc">A stacked ensemble model processes the inputs and classifies the student's mental health status.</p>
                </div>
                <div class="wl-step-card">
                    <p class="wl-step-num">Step 03</p>
                    <div class="wl-step-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h3 class="wl-step-title">AI Guidance</h3>
                    <p class="wl-step-desc">Personalized, empathetic recommendations are generated immediately by our Gemini-powered counselor.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section id="features" class="wl-features-bg">
        <div class="wl-features-inner">
            <p class="wl-section-label" style="color: #4b5563;">System Features</p>
            <h2 class="wl-section-title" style="color: #f9fafb;">Built for schools,<br>designed for everyone in them</h2>

            <div class="wl-features-grid">
                @php
                    $features = [
                        ['icon' => 'fa-bolt',         'title' => 'Real-time Predictions',  'desc' => 'Instant analysis using trained ML models for immediate, actionable results.'],
                        ['icon' => 'fa-chart-pie',    'title' => 'Diagnostic Insights',    'desc' => 'Data visualizations to support institutional decisions and resource planning.'],
                        ['icon' => 'fa-user-shield',  'title' => 'Role-based Access',      'desc' => 'Segmented access controls for Admins, Teachers, and Students.'],
                        ['icon' => 'fa-lock',         'title' => 'Data Privacy',           'desc' => 'Personal and academic data is protected with encryption-based controls.'],
                        ['icon' => 'fa-history',      'title' => 'Prediction History',     'desc' => 'Full audit trails and historical archives for longitudinal tracking.'],
                        ['icon' => 'fa-gears',        'title' => 'Scalable Architecture',  'desc' => 'Designed for smooth performance across multiple departments and cohorts.'],
                    ];
                @endphp

                @foreach($features as $feature)
                    <div class="wl-feature-item">
                        <div class="wl-feature-icon">
                            <i class="fas {{ $feature['icon'] }}"></i>
                        </div>
                        <h3 class="wl-feature-title">{{ $feature['title'] }}</h3>
                        <p class="wl-feature-desc">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="wl-footer">
        <div class="wl-footer-logo">
            <img src="{{ asset('images/logo.png') }}" alt="SMHPIS Logo" class="wl-footer-logo-icon" style="background: none; object-fit: contain;">
            <span class="wl-footer-logo-text">SMHPIS</span>
        </div>
        <p class="wl-footer-school">BTECH Computer Science &nbsp;&middot;&nbsp; Accra Technical University</p>
        <div class="wl-footer-divider"></div>
        <p class="wl-footer-copy">© {{ date('Y') }} SMHPIS. All rights reserved.</p>
    </footer>

</body>
</html>
