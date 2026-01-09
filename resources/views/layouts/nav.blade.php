<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <img src="{{ asset('assets/img/Agrivall_Logo.png') }}" alt="Agrivall Logo" height="40" class="bg-white rounded ml-2 me-2"/>
        <a class="navbar-brand fw-bold" href="/">Agrivall</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productos.index') }}">Gestion de productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productos.catalogo') }}">Catálogo</a>
                </li>
                <!-- Más enlaces en el futuro -->
            </ul>
        </div>
    </div>
</nav>