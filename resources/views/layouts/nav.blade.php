<style>
    .navbar-agrivall {
        position: relative;
        z-index: 1030 !important;
    }

    .nav-link.dropdown-toggle:hover {
        background: rgba(255, 255, 255, 0.2) !important;
        border-color: rgba(255, 255, 255, 0.4) !important;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .nav-link.dropdown-toggle[aria-expanded="true"] {
        background: rgba(255, 255, 255, 0.25) !important;
        border-color: rgba(255, 255, 255, 0.5) !important;
    }

    .nav-item.dropdown {
        position: relative;
        z-index: 1031;
    }

    .dropdown-menu {
        border: none;
        margin-top: 0.5rem;
        z-index: 1032 !important;
        position: absolute !important;
    }

    .dropdown-item {
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background: var(--agrivall-green-primary);
        color: white;
        transform: translateX(3px);
    }
</style>

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
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-1 px-3 py-2 rounded"
                                href="#" id="navbarDropdownAdmin" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false"
                                style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); transition: all 0.3s ease;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-gear-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                                </svg>
                                <span class="fw-semibold">Admin</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                    class="bi bi-chevron-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                </svg>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="navbarDropdownAdmin"
                                style="min-width: 200px;">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                        href="{{ route('productos.index') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                                            <path
                                                d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z" />
                                        </svg>
                                        Gestionar Productos
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                        href="{{ route('admin.reservas.index') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                                            <path
                                                d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                                            <path
                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                        </svg>
                                        Gestionar Reservas
                                    </a>
                                </li>
                            </ul>
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
