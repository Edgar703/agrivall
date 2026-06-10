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
                    <a href="{{ route('admin.productos.edit', $producto) }}" class="btn btn-agrivall-secondary">
                        ✏️ Editar Producto
                    </a>
                @endif
            @endauth
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
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
                        $productoImagen =
                            $producto->imagen &&
                            \Illuminate\Support\Facades\Storage::disk('public')->exists($producto->imagen)
                            ? asset('storage/' . $producto->imagen)
                            : asset('assets/img/Agrivall_Logo.png');
                        $variedadesActivasJson = $producto->variedades
                            ->where('activo', true)
                            ->values()
                            ->map(fn($variedad) => [
                                'id' => $variedad->id,
                                'nombre' => $variedad->nombre,
                                'precio' => $variedad->precio,
                                'stock' => $variedad->controla_stock ? (float) $variedad->stock_actual : null,
                                'agotada' => $variedad->controla_stock && (float) $variedad->stock_actual < (float) $producto->step_cantidad,
                            ]);
                        $variedadesActivas = $producto->variedades->where('activo', true);
                        $usaStockVariedades = $variedadesActivas->isNotEmpty();
                        $puedeComprar = $usaStockVariedades
                            ? $variedadesActivas->contains(fn($variedad) => !$variedad->controla_stock || (float) $variedad->stock_actual >= (float) $producto->step_cantidad)
                            : (!$producto->controla_stock || (float) $producto->stock_actual >= (float) $producto->step_cantidad);
                        $stockBajo = $usaStockVariedades
                            ? $variedadesActivas->contains(fn($variedad) => $variedad->tieneStockBajo())
                            : $producto->tieneStockBajo();
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
                            <h2 class="heading-1 text-green mb-0">{{ number_format($producto->precio, 2) }}
                                €/{{ $producto->unidad_medida }}</h2>
                            <div class="mt-3">
                                @if (!$puedeComprar)
                                    <span class="badge bg-danger">Agotado</span>
                                @elseif ($stockBajo)
                                    <span class="badge bg-warning text-dark">Últimas unidades</span>
                                @else
                                    <span class="badge bg-success">Disponible</span>
                                @endif
                            </div>
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

                            @if ($producto->variedades->where('activo', true)->isNotEmpty())
                                <div class="d-flex align-items-center mb-3 p-3 bg-natural rounded">
                                    <div class="flex-grow-1">
                                        <span class="text-muted small">Variedades</span>
                                        <p class="mb-0 fw-semibold">
                                            {{ $producto->variedades->where('activo', true)->pluck('nombre')->join(', ') }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex align-items-center p-3 bg-natural rounded">
                                <div class="flex-grow-1">
                                    <span class="text-muted small">Estado</span>
                                    <p class="mb-0 fw-semibold">
                                        @if ($producto->activo)
                                            <span class="text-success">Activo</span>
                                        @else
                                            <span class="text-danger">Inactivo</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            @if ($usaStockVariedades)
                                <div class="d-flex align-items-center mt-3 p-3 bg-natural rounded">
                                    <div class="flex-grow-1">
                                        <span class="text-muted small">Stock por variedad</span>
                                        @foreach ($variedadesActivas as $variedad)
                                            <p class="mb-0 fw-semibold">
                                                {{ $variedad->nombre }}:
                                                {{ $variedad->controla_stock ? $variedad->etiquetaStock($producto->unidad_medida) : 'Disponible' }}
                                            </p>
                                        @endforeach
                                    </div>
                                </div>
                            @elseif ($producto->controla_stock)
                                <div class="d-flex align-items-center mt-3 p-3 bg-natural rounded">
                                    <div class="flex-grow-1">
                                        <span class="text-muted small">Stock disponible</span>
                                        <p class="mb-0 fw-semibold">
                                            {{ $producto->etiquetaStock() }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Botones de acción --}}
                        <div class="d-flex gap-2">
                            <a href="{{ route('productos.catalogo') }}" class="btn btn-agrivall-outline flex-grow-1">
                                ← Volver al catálogo
                            </a>
                            @auth
                                @if ($producto->activo && $puedeComprar)
                                    <button type="button" class="btn btn-agrivall-primary flex-grow-1 js-open-cart-modal"
                                        data-product-id="{{ $producto->id }}" data-product-name="{{ $producto->nombre }}"
                                        data-product-category="{{ $producto->categoria?->nombre ?? 'Sin categoria' }}"
                                        data-product-price="{{ $producto->precio }}" data-product-image="{{ $productoImagen }}"
                                        data-product-sale-type="{{ $producto->tipo_venta }}"
                                        data-product-unit="{{ $producto->unidad_medida }}"
                                        data-product-step="{{ $producto->step_cantidad }}"
                                        data-product-stock="{{ !$usaStockVariedades && $producto->controla_stock ? $producto->stock_actual : '' }}"
                                        data-product-variedades='@json($variedadesActivasJson)'>
                                        🛒 Añadir al carrito
                                    </button>
                                @elseif (!$puedeComprar)
                                    <button type="button" class="btn btn-secondary flex-grow-1" disabled>
                                        Agotado
                                    </button>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @auth
        @include('productos.partials.add-to-cart-modal')
    @endauth
@endsection
