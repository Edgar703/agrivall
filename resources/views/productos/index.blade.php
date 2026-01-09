@extends('layouts.app')

@section('titol', 'Productos')

@section('contingut')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Gestor de Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-primary">+ Nuevo</a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        setTimeout(function() {
            let alert = document.querySelector('.alert-success');
            if(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 3000);
    </script>
@endif

<table class="table table-striped align-middle">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Variedad</th>
            <th>Formato</th>
            <th>Precio</th>
            <th>Disponible</th>
            <th class="text-end">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($productos as $producto)
            <tr>
                <td>{{ $producto->id }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->variedad }}</td>
                <td>{{ $producto->formato }}</td>
                <td>{{ number_format($producto->precio, 2) }} €</td>
                <td>
                    @if($producto->disponible)
                        <span class="badge bg-success">Sí</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </td>
                <td class="text-end">
                    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-warning">Editar</a>

                    <form action="{{ route('productos.destroy', $producto) }}"
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Seguro que quieres borrarlo?')">
                            Borrar
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center">No hay productos</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
