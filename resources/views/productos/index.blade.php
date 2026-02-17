@extends('layouts.app')

@section('titol', 'Productos')

@section('contingut')
    <div class="animate-fadeInUp">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="heading-2 text-green mb-0">Gestor de Productos</h1>
            <a href="{{ route('productos.create') }}" class="btn btn-agrivall-primary">
                + Nuevo Producto
            </a>
        </div>

        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control-agrivall"
                placeholder="🔍 Buscar por nombre o categoria...">
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

        <div class="table-agrivall">
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
                        <tr class="transition-colors">
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
                                <a href="{{ route('productos.edit', $producto) }}" class="btn btn-agrivall-primary btn-sm me-1">
                                    Editar
                                </a>

                                <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline">
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
    </div>

    @push('scripts')
        <script>
            console.log('Script de filtro cargado');

            const setupFilter = function () {
                console.log('setupFilter ejecutado');
                const searchInput = document.getElementById('searchInput');
                const tableRows = document.querySelectorAll('tbody tr');

                console.log('Input encontrado:', !!searchInput);
                console.log('Filas encontradas:', tableRows.length);

                if (searchInput && tableRows.length > 0) {
                    searchInput.addEventListener('input', function () {
                        const searchValue = this.value.toLowerCase().trim();
                        console.log('Buscando:', searchValue);

                        tableRows.forEach(row => {
                            const cells = row.querySelectorAll('td');
                            if (cells.length > 0) {
                                const rowText = Array.from(cells).slice(0, 4)
                                    .map(cell => cell.textContent.toLowerCase().trim())
                                    .join(' ');

                                const shouldShow = searchValue === '' || rowText.includes(searchValue);
                                row.style.display = shouldShow ? '' : 'none';
                            }
                        });
                    });
                    console.log('Listener de input agregado');
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