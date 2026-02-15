@extends('layouts.app')

@section('titol', 'Catálogo')

@section('contingut')
    <div class="animate-fadeInUp">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="heading-2 text-green mb-1">Catálogo de Productos</h1>
                <p class="text-muted mb-0">Descubre nuestros productos naturales</p>
            </div>

            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('productos.create') }}" class="btn btn-agrivall-primary">
                        + Nuevo Producto
                    </a>
                @endif
            @endauth
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
            @php $delay = 0; @endphp
            @forelse($productos as $producto)
                @if ($producto->disponible === 1)
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 animate-fadeInUp animate-stagger-{{ $delay % 4 + 1 }}">
                        @php $delay++; @endphp
                        <div class="product-card h-100 d-flex flex-column">
                            {{-- Imagen --}}
                            @php
                                $productoImagen = ($producto->imagen
                                    && \Illuminate\Support\Facades\Storage::disk('public')->exists($producto->imagen))
                                    ? asset('storage/' . $producto->imagen)
                                    : asset('assets/img/Agrivall_Logo.png');
                            @endphp

                            <div class="position-relative overflow-hidden" style="height: 240px;">
                                <a href="{{ route('productos.show', $producto) }}" class="d-block h-100">
                                    <img src="{{ $productoImagen }}" class="product-card-img w-100 h-100"
                                        alt="{{ $producto->nombre }}" style="object-fit: cover;">
                                    <div class="position-absolute inset-0"
                                        style="background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.4) 100%); pointer-events: none;">
                                    </div>
                                </a>
                                {{-- <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge"
                                        style="background-color: rgba(45, 106, 79, 0.95); font-size: 0.7rem; padding: 0.35rem 0.6rem; font-weight: 500;">
                                        DISPONIBLE
                                    </span>
                                </div> --}}
                            </div>

                            <div class="card-body p-4 d-flex flex-column flex-grow-1">
                                <h5 class="mb-3 fw-bold"
                                    style="color: var(--agrivall-gray-900); font-size: 1.1rem; line-height: 1.3;">
                                    {{ $producto->nombre }}
                                </h5>

                                <div class="mb-3 pb-3" style="border-bottom: 1px solid var(--agrivall-gray-200);">
                                    @if($producto->variedad)
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="text-muted"
                                                style="font-size: 0.8rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; min-width: 70px;">Variedad</span>
                                            <span class="ms-2"
                                                style="color: var(--agrivall-gray-700); font-size: 0.9rem;">{{ $producto->variedad }}</span>
                                        </div>
                                    @endif
                                    @if($producto->formato)
                                        <div class="d-flex align-items-center">
                                            <span class="text-muted"
                                                style="font-size: 0.8rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; min-width: 70px;">Formato</span>
                                            <span class="ms-2"
                                                style="color: var(--agrivall-gray-700); font-size: 0.9rem;">{{ $producto->formato }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-0 mt-auto">
                                    <div>
                                        <div class="text-muted" style="font-size: 0.75rem; font-weight: 500;">PRECIO</div>
                                        <div class="fw-bold"
                                            style="color: var(--agrivall-green-primary); font-size: 1.5rem; line-height: 1;">
                                            {{ number_format($producto->precio, 2) }}<span style="font-size: 0.9rem;"> €</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('productos.show', $producto) }}" class="btn btn-agrivall-primary btn-sm px-3"
                                        style="font-size: 0.85rem;">
                                        Ver más
                                    </a>
                                </div>
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
                @endif
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
@endsection