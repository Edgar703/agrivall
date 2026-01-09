@extends('layouts.app')

@section('titol', 'Productos')

@section('contingut')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-primary">+ Nuevo</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-3">
    @forelse($productos as $producto)
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card h-100 shadow-sm">

                {{-- Imagen --}}
                @if($producto->imagen)
                    <img
                        src="{{ asset('storage/' . $producto->imagen) }}"
                        class="card-img-top"
                        alt="{{ $producto->nombre }}"
                        style="height: 180px; object-fit: cover;"
                    >
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center"
                         style="height: 180px;">
                        <span class="text-muted">Sin imagen</span>
                    </div>
                @endif

                <div class="card-body">
                    <h5 class="card-title mb-1">{{ $producto->nombre }}</h5>
                    <p class="card-text text-muted mb-2">
                        {{ $producto->variedad ?? '—' }} · {{ $producto->formato ?? '—' }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center">
                        <strong>{{ number_format($producto->precio, 2) }} €</strong>

                        @if($producto->disponible)
                            <span class="badge bg-success">Disponible</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </div>
                </div>

                <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                    <div class="d-flex gap-2">
                        <a href="{{ route('productos.edit', $producto) }}"
                           class="btn btn-warning btn-sm flex-grow-1">
                            Editar
                        </a>

                        <form action="{{ route('productos.destroy', $producto) }}"
                              method="POST" class="flex-grow-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-danger btn-sm w-100"
                                    onclick="return confirm('¿Seguro que quieres borrarlo?')">
                                Borrar
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info mb-0">
                No hay productos todavía. <a href="{{ route('productos.create') }}">Crea el primero</a>.
            </div>
        </div>
    @endforelse
</div>
@endsection
