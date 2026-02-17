@extends('layouts.app')

@section('titol', 'Catálogo')

@section('contingut')
    <div class="animate-fadeInUp">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="heading-2 text-green mb-1">Catálogo de Productos</h1>
                <p class="text-muted mb-0">Descubre nuestros productos naturales</p>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-agrivall-outline d-lg-none" data-bs-toggle="modal"
                    data-bs-target="#catalogoFiltrosModal">
                    Filtros
                </button>
                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('productos.create') }}" class="btn btn-agrivall-primary">
                            + Nuevo Producto
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-slideUp" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function () {
                    let alert = document.querySelector('.alert-success');
                    if (alert) {
                        let bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 3000);
            </script>
        @endif

        <div class="row g-4">
            <aside class="col-lg-3 d-none d-lg-block">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="heading-4 text-earth mb-3">Filtrar productos</h5>
                        <form action="{{ route('productos.catalogo') }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label-agrivall">Buscar</label>
                                <input type="text" name="q" class="form-control-agrivall" value="{{ request('q') }}"
                                    placeholder="Nombre del producto">
                            </div>

                            <div class="mb-3">
                                <label class="form-label-agrivall">Rango de precio (€)</label>
                                <div class="d-grid gap-2">
                                    <input type="number" name="precio_min" class="form-control-agrivall" min="0"
                                        step="0.01" value="{{ request('precio_min') }}" placeholder="Mínimo">
                                    <input type="number" name="precio_max" class="form-control-agrivall" min="0"
                                        step="0.01" value="{{ request('precio_max') }}" placeholder="Máximo">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label-agrivall">Categoría</label>
                                <select name="categoria_id" class="form-control-agrivall">
                                    <option value="">Todas</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}"
                                            {{ (string) request('categoria_id') === (string) $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-agrivall-primary btn-sm">Aplicar filtros</button>
                                <a href="{{ route('productos.catalogo') }}" class="btn btn-agrivall-outline btn-sm">Limpiar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="col-lg-9">
                <div class="row g-4">
                    @php $delay = 0; @endphp
                    @forelse($productos as $producto)
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 animate-fadeInUp animate-stagger-{{ $delay % 4 + 1 }}">
                            @php $delay++; @endphp
                            <div class="product-card h-100 d-flex flex-column">
                                @php
                                    $productoImagen = ($producto->imagen
                                        && \Illuminate\Support\Facades\Storage::disk('public')->exists($producto->imagen))
                                        ? \Illuminate\Support\Facades\Storage::disk('public')->url($producto->imagen)
                                        : asset('assets/img/Agrivall_Logo.png');
                                @endphp
                                <div class="position-relative overflow-hidden" style="height: 200px;">
                                    <a href="{{ route('productos.show', $producto) }}" class="d-block h-100">
                                        <img src="{{ $productoImagen }}" class="product-card-img w-100 h-100"
                                            alt="{{ $producto->nombre }}" style="object-fit: cover;">
                                    </a>
                                </div>
                                <div class="p-4 border-bottom" style="background: linear-gradient(135deg, #f4f7f2 0%, #ffffff 100%);">
                                    <h5 class="mt-2 mb-0 fw-bold" style="color: var(--agrivall-gray-900); font-size: 1.2rem;">
                                        {{ $producto->nombre }}
                                    </h5>
                                </div>

                                <div class="card-body p-4 d-flex flex-column flex-grow-1">
                                    {{-- @if($producto->descripcion)
                                    <p class="text-muted mb-3" style="font-size: 0.9rem;">
                                        {{ \Illuminate\Support\Str::limit($producto->descripcion, 120) }}
                                    </p>
                                    @endif --}}

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <div class="text-muted" style="font-size: 0.75rem; font-weight: 500;">PRECIO</div>
                                            <div class="fw-bold"
                                                style="color: var(--agrivall-green-primary); font-size: 1.5rem; line-height: 1;">
                                                {{ number_format($producto->precio, 2) }}<span style="font-size: 0.9rem;"> €</span>
                                            </div>
                                            <div class="text-muted"
                                                style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px;">
                                                {{ $producto->categoria?->nombre ?? 'Sin categoria' }}
                                            </div>
                                        </div>
                                    </div>

                                    <a href="{{ route('productos.show', $producto) }}"
                                        class="btn btn-agrivall-primary btn-sm px-3 mt-auto" style="font-size: 0.85rem;">
                                        Ver más
                                    </a>
                                </div>
                                {{--
                                @auth
                                @if (auth()->user()->role === 'admin')
                                <div class="card-footer bg-light border-0 p-3"
                                    style="border-top: 1px solid var(--agrivall-gray-200) !important;">
                                    <div class="d-flex gap-2 justify-content-between align-items-center">
                                        <a href="{{ route('productos.edit', $producto) }}"
                                            class="btn btn-agrivall-primary btn-sm flex-grow-1">
                                            Editar
                                        </a>
                                        <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="flex-grow-1">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-agrivall-danger btn-sm w-100"
                                                onclick="return confirm('¿Seguro que quieres borrar este producto?')">
                                                Borrar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                                @endauth --}}
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <h3 class="heading-4 text-muted">No hay productos disponibles</h3>
                                @auth
                                    @if (auth()->user()->role === 'admin')
                                        <p class="text-muted mb-3">Comienza creando tu primer producto</p>
                                        <a href="{{ route('productos.create') }}" class="btn btn-agrivall-primary">
                                            + Crear Producto
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Filtros (movil) --}}
    <div class="modal fade" id="catalogoFiltrosModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: var(--radius-lg); overflow: hidden;">
                <div class="modal-header" style="background: var(--gradient-earth); color: white;">
                    <h5 class="modal-title fw-semibold">Filtrar productos</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('productos.catalogo') }}" method="GET" class="js-filter-modal-form">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label-agrivall">Buscar</label>
                            <input type="text" name="q" class="form-control-agrivall" value="{{ request('q') }}"
                                placeholder="Nombre del producto">
                        </div>

                        <div class="mb-3">
                            <label class="form-label-agrivall">Rango de precio (EUR)</label>
                            <div class="d-grid gap-2">
                                <input type="number" name="precio_min" class="form-control-agrivall" min="0"
                                    step="0.01" value="{{ request('precio_min') }}" placeholder="Minimo">
                                <input type="number" name="precio_max" class="form-control-agrivall" min="0"
                                    step="0.01" value="{{ request('precio_max') }}" placeholder="Maximo">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-agrivall">Categoria</label>
                            <select name="categoria_id" class="form-control-agrivall">
                                <option value="">Todas</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}"
                                        {{ (string) request('categoria_id') === (string) $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <a href="{{ route('productos.catalogo') }}" class="btn btn-agrivall-outline">Limpiar</a>
                        <button type="submit" class="btn btn-agrivall-primary">Aplicar filtros</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let forms = document.querySelectorAll('.js-filter-modal-form');
            forms.forEach(function (form) {
                form.addEventListener('submit', function () {
                    let modalEl = form.closest('.modal');
                    if (!modalEl) {
                        return;
                    }
                    let modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) {
                        modal.hide();
                    }
                });
            });
        });
    </script>
@endsection