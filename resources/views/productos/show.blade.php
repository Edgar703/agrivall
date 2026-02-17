@extends('layouts.app')

@section('titol', 'Detalle del Producto')

@section('contingut')
    <div class="animate-fadeInUp">
        {{-- Breadcrumb y acciones --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('productos.catalogo') }}" class="text-green">Catálogo</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $producto->nombre }}</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="heading-2 text-green mb-0">{{ $producto->nombre }}</h1>
            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-agrivall-secondary">
                        ✏️ Editar Producto
                    </a>
                @endif
            @endauth
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Contenido principal --}}
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card-agrivall">
                    @php
                        $productoImagen = ($producto->imagen
                            && \Illuminate\Support\Facades\Storage::disk('public')->exists($producto->imagen))
                            ? asset('storage/' . $producto->imagen)
                            : asset('assets/img/Agrivall_Logo.png');
                    @endphp
                    <div class="img-zoom">
                        <img src="{{ $productoImagen }}" alt="{{ $producto->nombre }}" class="w-100"
                            style="height: 500px; object-fit: cover;">
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card-agrivall h-100">
                    <div class="card-body p-4">
                        {{-- Precio destacado --}}
                        <div class="mb-4 pb-4 border-bottom">
                            <span class="text-muted small d-block mb-2">Precio</span>
                            <h2 class="heading-1 text-green mb-0">{{ number_format($producto->precio, 2) }} €</h2>
                        </div>

                        <div class="mb-4">
                            <h5 class="heading-5 mb-3 text-earth">Descripcion</h5>
                            <p class="mb-0 text-muted">{{ $producto->descripcion ?? 'Sin descripcion.' }}</p>
                        </div>

                        <div class="mb-4">
                            <h5 class="heading-5 mb-3 text-earth">Informacion del Producto</h5>

                            <div class="d-flex align-items-center mb-3 p-3 bg-natural rounded">
                                <div class="flex-grow-1">
                                    <span class="text-muted small">Categoria</span>
                                    <p class="mb-0 fw-semibold">{{ $producto->categoria?->nombre ?? 'Sin categoria' }}</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center p-3 bg-natural rounded">
                                <div class="flex-grow-1">
                                    <span class="text-muted small">Estado</span>
                                    <p class="mb-0 fw-semibold">
                                        @if($producto->activo)
                                            <span class="text-success">Activo</span>
                                        @else
                                            <span class="text-danger">Inactivo</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="d-flex gap-2">
                            <a href="{{ route('productos.catalogo') }}" class="btn btn-agrivall-outline flex-grow-1">
                                ← Volver al catálogo
                            </a>
                            @if($producto->activo)
                                <button class="btn btn-agrivall-primary flex-grow-1" disabled>
                                    🛒 Añadir a reserva
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection