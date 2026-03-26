<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titol', 'Agrivall')</title>

    {{-- NO Bootstrap - Solo nuestro sistema CSS --}}
    <link rel="shortcut icon" href="{{ asset('assets/img/Agrivall_Logo.png') }}" type="image/x-icon">

    {{-- Sistema de diseño Agrivall (incluye grid-system.css + todas las variables) --}}
    @vite(['resources/css/app.css'])
    @stack('styles')
</head>

<body class="min-vh-100 d-grid" style="grid-template-rows: auto 1fr auto;">

    @include('layouts.nav')

    <main class="container py-4 bg-transparent">
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

    {{-- NO Bootstrap JS - Solo nuestras librerías --}}
    @stack('scripts')
</body>

</html>
