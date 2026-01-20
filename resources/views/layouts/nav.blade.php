<nav class="navbar navbar-expand-lg navbar-dark bg-success" style="min-height: 7vh;">
    <div class="container-fluid "style="width: 80%;">
        <img src="{{ asset('assets/img/Agrivall_Logo.png') }}" alt="Agrivall Logo" height="40" class="ms-2 me-2"/>
        <a class="navbar-brand fw-bold" style="font-size: 30px;" href="/">Agrivall</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productos.catalogo') }}">Catálogo</a>
                </li>

                {{-- Solo admin ve gestion --}}
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('productos.index') }}">Gestion de productos</a>
                        </li>
                    @endif
                @endauth
            </ul>
            
            <div class="d-flex flex-column flex-lg-row gap-2 align-items-lg-center ms-lg-3 mt-2 mt-lg-0">
                @auth
                    <span class="navbar-text text-white">
                        Hola, {{ auth()->user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn text-white btn-sm" style="background-color: brown; border-radius: 10px;">Salir</button>
                    </form>
                @else
                    <a class="btn text-white btn-sm" style="background-color: #735322; border-radius: 10px;" href="{{ route('login') }}">Login</a>
                    <a class="btn text-white btn-sm" style="background-color: #735322; border-radius: 10px;" href="{{ route('register') }}">Registro</a>
                @endauth
            </div>
        </div>
    </div>
</nav>