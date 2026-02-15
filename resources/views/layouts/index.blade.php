<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titol', 'Agrivall')</title>

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/img/Agrivall_Logo.png') }}" type="image/x-icon">

    {{-- Sistema de diseño Agrivall --}}
    @vite(['resources/css/app.css'])

    <style>
        .page-hero {
            --hero-nav-height: 7vh;
        }

        .page-hero .navbar-agrivall {
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .page-hero .hero-section {
            margin-top: calc(-1 * var(--hero-nav-height));
            padding-top: calc(3rem + var(--hero-nav-height));
        }

        .transition-hover {
            transition: all 0.3s ease;
        }

        .transition-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.15) !important;
        }

        .btn-agrivall-primary {
            background-color: #2d5016;
            color: white;
            border: none;
            padding: 0.65rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-agrivall-primary:hover {
            background-color: #1f3810;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(45, 80, 22, 0.3);
        }

        .btn-agrivall-secondary {
            background-color: transparent;
            color: #2d5016;
            border: 2px solid #2d5016;
            padding: 0.55rem 1.4rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-agrivall-secondary:hover {
            background-color: #2d5016;
            color: white;
            transform: translateY(-2px);
        }

        .hero-section {
            min-height: 650px;
            display: flex;
            align-items: center;
            position: relative;
        }

        .hero-section .hero-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
        }

        .hero-section .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-section .hero-panel {
            background: rgba(255, 255, 255, 0.45);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.12);
            backdrop-filter: blur(1px);
        }

        .hero-section .hero-content h1,
        .hero-section .hero-content p {
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.55);
        }

        @media (max-width: 768px) {
            .hero-section {
                min-height: 70vh;
                padding-top: calc(2.5rem + var(--hero-nav-height));
            }

            h1.display-4 {
                font-size: 2.2rem;
            }

            .page-hero section.py-5 {
                padding-top: 2.5rem !important;
                padding-bottom: 2.5rem !important;
            }

            .page-hero section.mb-5 {
                margin-bottom: 2.5rem !important;
            }

            .page-hero .hero-panel {
                margin-top: 1.5rem !important;
                padding: 1.25rem !important;
                background: rgba(255, 255, 255, 0.45) !important;
                box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.12) !important;
                backdrop-filter: blur(1px) !important;
            }

            .page-hero .hero-content .d-flex.gap-3 {
                flex-direction: column;
            }

            .page-hero .hero-content .btn {
                width: 100%;
            }

            .page-hero .hero-content .lead {
                font-size: 1rem;
            }

            .page-hero .hero-content h1,
            .page-hero .hero-content p {
                text-shadow: 0 2px 8px rgba(0, 0, 0, 0.55);
            }

            .page-hero .row.mb-5 {
                margin-bottom: 2rem !important;
            }

            .page-hero .card .bg-light.rounded-3.m-3 {
                height: 160px !important;
            }

            .page-hero section .col-lg-6 .bg-light.rounded-3 {
                height: 260px !important;
            }
        }
    </style>
</head>

<body class="min-vh-100 d-grid @yield('body-class')" style="grid-template-rows: auto 1fr auto;">

    @include('layouts.nav')

    <main class="bg-transparent">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @yield('contingut')
    </main>

    @include('layouts.footer')

    {{-- Bootstrap 5 JS Bundle CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>