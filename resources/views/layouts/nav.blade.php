<nav class="navbar navbar-expand-lg navbar-dark navbar-agrivall" style="min-height: 7vh;">
    <div class="container-fluid" style="width: 80%;">
        <a class="navbar-brand-agrivall fw-bold d-flex align-items-center" href="{{ route('index') }}">
            <img src="{{ asset('assets/img/Agrivall_Logo.png') }}" alt="Agrivall Logo" height="40" class="ms-2 me-2" />
            <span style="font-size: 30px; color: white;">Agrivall</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productos.catalogo') }}">Catálogo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('posts.index') }}">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('casa-rural') }}">Casa Rural</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contactar') }}">Contactar</a>
                </li>

                {{-- Solo admin ve gestion --}}
                @auth
                    @if (auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('productos.index') }}">Gestion de productos</a>
                        </li>
                    @endif
                @endauth
            </ul>

            <div class="d-flex flex-column flex-lg-row gap-2 align-items-lg-center ms-lg-3 mt-2 mt-lg-0">
                @auth
                    <span class="navbar-text text-white">
                        <a href="{{ route('profile.edit') }}" class="text-white text-decoration-none hover-underline">Mi
                            Cuenta</a>
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-agrivall-secondary btn-sm" type="submit">Salir</button>
                    </form>
                @else
                    <a class="btn btn-agrivall-secondary btn-sm" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-agrivall-secondary btn-sm" href="{{ route('register') }}">Registro</a>
                @endauth
            </div>
        </div>
    </div>
</nav>