<footer class="bg-success text-light mt-auto">
    <div class="container py-1">
        <div class="row">

            {{-- Columna izquierda --}}
            <div class="col-md-6 mb-3 mb-md-0">
                <h5 class="mb-2">Agrivall</h5>
                <p class="mb-0 small" >
                    Proyecto de gestión agrícola desarrollado con Laravel.
                </p>
            </div>

            {{-- Columna derecha --}}
            <div class="col-md-6 text-md-end">
                <ul class="list-inline mb-2">
                    <li class="list-inline-item">
                        <a href="{{ route('productos.catalogo') }}" class="text-light text-decoration-none">
                            Catálogo
                        </a>
                    </li>

                    <li class="list-inline-item">
                        <a href="{{ route('dashboard') }}" class="text-light text-decoration-none">
                            Dashboard
                        </a>
                    </li>
                </ul>

                <span class="small">
                    © {{ date('Y') }} Agrivall · Todos los derechos reservados
                </span>
            </div>

        </div>
    </div>
</footer>
