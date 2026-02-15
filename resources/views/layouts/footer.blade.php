<footer class="footer-agrivall text-light mt-auto">
    <div class="container py-2">
        <div class="row">

            {{-- Columna izquierda --}}
            <div class="col-md-6 mb-2 mb-md-0">
                <h6 class="mb-1 fw-bold" style="font-size: 0.95rem; color: white;">Agrivall</h6>
                <p class="mb-0 small" style="opacity: 0.9; font-size: 0.85rem; color: white;">
                    Proyecto de gestión agrícola desarrollado con Laravel.
                </p>
            </div>

            {{-- Columna derecha --}}
            <div class="col-md-6 text-md-end">
                <ul class="list-inline mb-1" style="margin-bottom: 0.25rem !important;">
                    <li class="list-inline-item">
                        <a href="{{ route('productos.catalogo') }}"
                            class="text-light text-decoration-none hover-underline" style="font-size: 0.85rem;">
                            Catálogo
                        </a>
                    </li>
                    <li class="list-inline-item mx-1" style="font-size: 0.75rem;">·</li>
                    <li class="list-inline-item">
                        <a href="{{ route('dashboard') }}" class="text-light text-decoration-none hover-underline"
                            style="font-size: 0.85rem;">
                            Dashboard
                        </a>
                    </li>
                </ul>

                <div class="small" style="opacity: 0.85; font-size: 0.8rem;">
                    © {{ date('Y') }} Agrivall · Todos los derechos reservados
                </div>
            </div>

        </div>
    </div>
</footer>