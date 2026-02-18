@extends('layouts.app')

@section('titol', 'Productos')

@section('contingut')
    <div class="animate-fadeInUp">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
            <h1 class="heading-2 text-green mb-0 fs-3 fs-md-2">Gestor de Productos</h1>
            <a href="{{ route('productos.create', ['return_to' => url()->full()]) }}" class="btn btn-agrivall-primary btn-sm">
                + Nuevo Producto
            </a>
        </div>

        <div class="mb-3 mb-md-4">
            <input type="text" id="searchInput" class="form-control-agrivall"
                placeholder="🔍 Buscar por nombre o categoria...">
        </div>

        @auth
            @if (auth()->user()->role === 'admin')
                <div class="card-agrivall mb-3 mb-md-4">
                    <div class="card-body p-3 p-md-4">
                        <button class="btn btn-agrivall-outline w-100 d-flex justify-content-between align-items-center"
                            type="button" data-bs-toggle="collapse" data-bs-target="#gestorCategoriasCollapse"
                            aria-expanded="{{ $errors->any() ? 'true' : 'false' }}" aria-controls="gestorCategoriasCollapse">
                            <span class="fw-semibold">Gestión de categorías</span>
                            <span class="small">Desplegar / Ocultar</span>
                        </button>

                        <div class="collapse mt-3 {{ $errors->any() ? 'show' : '' }}" id="gestorCategoriasCollapse">
                            <div class="row g-3">
                                <div class="col-12 col-lg-6">
                                    <form action="{{ route('categorias.store') }}" method="POST" class="d-grid gap-2">
                                        @csrf
                                        <div>
                                            <label for="categoria_nombre" class="form-label-agrivall">Nueva categoría</label>
                                            <input type="text" name="nombre" id="categoria_nombre"
                                                class="form-control-agrivall" value="{{ old('nombre') }}" maxlength="255"
                                                placeholder="Ej: Conservas" required>
                                        </div>
                                        <div>
                                            <label for="categoria_descripcion" class="form-label-agrivall">Descripción
                                                (opcional)</label>
                                            <textarea name="descripcion" id="categoria_descripcion" class="form-control-agrivall" rows="2"
                                                placeholder="Descripción corta">{{ old('descripcion') }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-agrivall-primary btn-sm">Crear categoría</button>
                                    </form>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label class="form-label-agrivall mb-2">Eliminar categoría</label>
                                    @if ($categorias->isEmpty())
                                        <div class="alert alert-info mb-0">No hay categorías para eliminar.</div>
                                    @else
                                        <div class="d-grid gap-2">
                                            @foreach ($categorias as $categoria)
                                                <div class="border rounded px-3 py-2 bg-white">
                                                    <div class="row g-2 align-items-center">
                                                        <div class="col-12 col-sm">
                                                            <span
                                                                class="fw-medium text-break d-block">{{ $categoria->nombre }}</span>
                                                        </div>
                                                        <div class="col-12 col-sm-auto">
                                                            <form action="{{ route('categorias.destroy', $categoria) }}"
                                                                method="POST" class="d-grid d-sm-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-agrivall-danger btn-sm"
                                                                    onclick="return confirm('¿Seguro que quieres borrar esta categoría? Los productos quedarán sin categoría.')">
                                                                    Eliminar
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endauth

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong>No se pudo completar la acción:</strong>
                <ul class="mb-0 mt-2 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-slideUp" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function() {
                    let alert = document.querySelector('.alert-success');
                    if (alert) {
                        let bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 3000);
            </script>
        @endif

        @if ($productos->isEmpty())
            <div class="alert alert-info" role="alert">
                <strong>Sin productos</strong> - No hay productos registrados.
            </div>
        @else
            <div class="d-md-none">
                @foreach ($productos as $producto)
                    <div class="card-agrivall mb-3 producto-item"
                        data-filter-text="{{ strtolower(trim($producto->nombre . ' ' . ($producto->categoria?->nombre ?? 'sin categoria') . ' ' . number_format($producto->precio, 2))) }}">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="fw-bold text-green mb-1">{{ $producto->nombre }}</h5>
                                    <p class="text-muted small mb-0">ID: {{ $producto->id }}</p>
                                </div>
                                @if ($producto->activo)
                                    <span class="badge badge-available">Activo</span>
                                @else
                                    <span class="badge badge-unavailable">Inactivo</span>
                                @endif
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <p class="text-muted small mb-0">Categoría</p>
                                    <p class="fw-semibold mb-0 small">
                                        {{ $producto->categoria?->nombre ?? 'Sin categoria' }}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-muted small mb-0">Precio</p>
                                    <p class="text-green fw-bold mb-0">{{ number_format($producto->precio, 2) }} €</p>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('productos.edit', $producto) }}"
                                    class="btn btn-agrivall-primary btn-sm flex-fill">
                                    Editar
                                </a>
                                <form action="{{ route('productos.destroy', $producto) }}" method="POST"
                                    class="flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-agrivall-danger btn-sm w-100"
                                        onclick="return confirm('¿Seguro que quieres borrar este producto?')">
                                        Borrar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="table-agrivall d-none d-md-block">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Precio</th>
                            <th>Activo</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                            <tr class="transition-colors producto-item"
                                data-filter-text="{{ strtolower(trim($producto->nombre . ' ' . ($producto->categoria?->nombre ?? 'sin categoria') . ' ' . number_format($producto->precio, 2))) }}">
                                <td class="fw-semibold">{{ $producto->id }}</td>
                                <td class="fw-medium">{{ $producto->nombre }}</td>
                                <td>{{ $producto->categoria?->nombre ?? 'Sin categoria' }}</td>
                                <td class="text-green fw-semibold">{{ number_format($producto->precio, 2) }} €</td>
                                <td>
                                    @if ($producto->activo)
                                        <span class="badge badge-available">Activo</span>
                                    @else
                                        <span class="badge badge-unavailable">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('productos.edit', $producto) }}"
                                        class="btn btn-agrivall-primary btn-sm me-1">
                                        Editar
                                    </a>

                                    <form action="{{ route('productos.destroy', $producto) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-agrivall-danger btn-sm"
                                            onclick="return confirm('¿Seguro que quieres borrar este producto?')">
                                            Borrar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    No hay productos registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            const setupFilter = function() {
                const searchInput = document.getElementById('searchInput');
                const productItems = document.querySelectorAll('.producto-item');

                if (searchInput && productItems.length > 0) {
                    searchInput.addEventListener('input', function() {
                        const searchValue = this.value.toLowerCase().trim();

                        productItems.forEach(item => {
                            const filterText = item.dataset.filterText || '';
                            const shouldShow = searchValue === '' || filterText.includes(searchValue);
                            item.style.display = shouldShow ? '' : 'none';
                        });
                    });
                }
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', setupFilter);
            } else {
                setupFilter();
            }
        </script>
    @endpush
@endsection
