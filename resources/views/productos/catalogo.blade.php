@extends('layouts.app')

@section('titol', 'Productos')

@section('contingut')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Productos</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
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

    <div class="row g-3">

        @forelse($productos as $producto)
            @if ($producto->disponible === 1)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow-sm">
                        {{-- Imagen --}}
                        @if($producto->imagen)
                            <a href="{{ route('productos.show', $producto) }}">
                                <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top" alt="{{ $producto->nombre }}"
                                style="height: 180px; object-fit: cover;">
                            </a>
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
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
                        @auth
                            @if (auth()->user()->role === 'admin')
                                <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm flex-grow-1" style="background-color: #198754; border: 2px solid #735122; color: white;">
                                            <strong>Editar</strong>
                                        </a>

                                        <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="flex-grow-1" >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm w-100" style="background-color: #735122; border: 2px solid #198754; color: white;"
                                                onclick="return confirm('¿Seguro que quieres borrarlo?')">
                                                <strong>Borrar</strong>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            @endif
        @empty
            @auth
                @if (auth()->user()->role === 'admin')
                    <div class="col-12">
                        <div class="alert alert-info mb-0">
                            No hay productos todavía. Crea el primero.
                        </div>
                    </div>
                @endif
            @endauth
        @endforelse
        @auth
            @if (auth()->user()->role === 'admin')
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('productos.create') }}" class="btn btn-primary" style="background-color: #198754; border: 2px solid #735122; color: white;">+ Nuevo</a>
                </div>
            @endif
        @endauth
    </div>
@endsection