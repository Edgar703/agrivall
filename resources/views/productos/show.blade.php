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
            {{-- Columna izquierda: Imagen --}}
            <div class="col-lg-6">
                <div class="card-agrivall">
                    @php
                        $rawImagen = $producto->imagen;
                        $normalImagen = $rawImagen ? preg_replace('#^storage/#', '', $rawImagen) : null;
                        $productoImagen = $normalImagen && \Illuminate\Support\Facades\Storage::disk('public')->exists($normalImagen)
                            ? asset('storage/' . $normalImagen)
                            : asset('assets/img/Agrivall_Logo.png');
                    @endphp
                    <div class="img-zoom">
                        <img src="{{ $productoImagen }}" alt="{{ $producto->nombre }}" class="w-100"
                            style="height: 500px; object-fit: cover;">
                    </div>
                </div>
            </div>

            {{-- Columna derecha: Información --}}
            <div class="col-lg-6">
                <div class="card-agrivall h-100">
                    <div class="card-body p-4">
                        {{-- Precio destacado --}}
                        <div class="mb-4 pb-4 border-bottom">
                            <span class="text-muted small d-block mb-2">Precio</span>
                            <h2 class="heading-1 text-green mb-0">{{ number_format($producto->precio, 2) }} €</h2>
                        </div>

                        {{-- Detalles del producto --}}
                        <div class="mb-4">
                            <h5 class="heading-5 mb-3 text-earth">Información del Producto</h5>

                            <div class="d-flex align-items-center mb-3 p-3 bg-natural rounded">
                                <div class="me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        class="text-green" viewBox="0 0 16 16">
                                        <path
                                            d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z" />
                                        <path
                                            d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z" />
                                    </svg>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="text-muted small">Variedad</span>
                                    <p class="mb-0 fw-semibold">{{ $producto->variedad ?? 'No especificada' }}</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3 p-3 bg-natural rounded">
                                <div class="me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        class="text-green" viewBox="0 0 16 16">
                                        <path
                                            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                                    </svg>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="text-muted small">Formato</span>
                                    <p class="mb-0 fw-semibold">{{ $producto->formato ?? 'No especificado' }}</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center p-3 bg-natural rounded">
                                <div class="me-3">
                                    @if($producto->disponible)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                            class="text-success" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                            class="text-danger" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <span class="text-muted small">Disponibilidad</span>
                                    <p class="mb-0 fw-semibold">
                                        @if($producto->disponible)
                                            <span class="text-success">Disponible ahora</span>
                                        @else
                                            <span class="text-danger">No disponible</span>
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
                            @if($producto->disponible)
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