<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('titol', 'Agrivall')</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div style="display: grid; min-height: 100vh; grid-template-rows: auto 1fr auto;">
    
    <!-- Navbar -->
    @include('layouts.nav')

    <!-- Main Content -->
    <main class="container mt-4">
        @yield('contingut')
    </main>

    <!-- Footer -->
    <footer class="bg-light text-center py-3 mt-5">
        <small>© {{ date('Y') }} Agrivall</small>
    </footer>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
