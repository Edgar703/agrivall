@extends('layouts.app')

@section('titol', 'Mi Carrito')

@section('contingut')
    @php
        $formatCantidad = function ($cantidad, $tipoVenta) {
            return $tipoVenta === 'peso'
                ? number_format((float) $cantidad, 2, ',', '')
                : number_format((float) $cantidad, 0, ',', '');
        };
    @endphp
    <div class="animate-fadeInUp">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="heading-2 text-green mb-1">Mi Carrito</h1>
                <p class="text-muted mb-0">Revisa los productos antes de realizar tu pedido</p>
            </div>
            <a href="{{ route('productos.catalogo') }}" class="btn btn-agrivall-outline btn-sm">← Seguir comprando</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-slideUp" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show animate-slideUp" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (empty($productos))
            <div class="text-center py-5">
                <h3 class="heading-4 text-muted">Tu carrito está vacío</h3>
                <p class="text-muted mb-3">Explora nuestro catálogo y añade productos</p>
                <a href="{{ route('productos.catalogo') }}" class="btn btn-agrivall-primary">Ver Catálogo</a>
            </div>
        @else
            <div class="table-agrivall">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Precio</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @php
                                            $img =
                                                $item['producto']->imagen &&
                                                \Illuminate\Support\Facades\Storage::disk('public')->exists($item['producto']->imagen)
                                                ? asset('storage/' . $item['producto']->imagen)
                                                : asset('assets/img/Agrivall_Logo.png');
                                        @endphp
                                        <img src="{{ $img }}" alt="{{ $item['producto']->nombre }}" class="rounded"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                        <div>
                                            <span class="fw-semibold">{{ $item['producto']->nombre }}</span>
                                            @if ($item['variedad'])
                                                <small class="d-block text-muted">Variedad: {{ $item['variedad']->nombre }}</small>
                                            @endif
                                            <small class="d-block text-muted">
                                                {{ $item['producto']->categoria?->nombre ?? '' }} ·
                                                {{ ucfirst($item['tipo_venta']) }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    {{ number_format($item['precio_unitario'], 2) }} €/{{ $item['unidad_medida'] }}
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('carrito.update') }}" method="POST"
                                        class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="item_key" value="{{ $item['item_key'] }}">
                                        <input type="number" name="cantidad"
                                            value="{{ $item['tipo_venta'] === 'peso' ? number_format($item['cantidad'], 2, '.', '') : (int) $item['cantidad'] }}"
                                            min="{{ number_format($item['step_cantidad'], 2, '.', '') }}"
                                            step="{{ number_format($item['step_cantidad'], 2, '.', '') }}"
                                            class="form-control form-control-sm text-center" style="width: 90px;">
                                        <span class="small text-muted">{{ $item['unidad_medida'] }}</span>
                                        <button type="submit" class="btn btn-agrivall-outline btn-sm">✓</button>
                                    </form>
                                </td>
                                <td class="text-center fw-bold text-green">
                                    {{ number_format($item['subtotal'], 2) }} €
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('carrito.remove', $item['item_key']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-agrivall-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end mt-4">
                <div class="col-md-5 col-lg-4">
                    <div class="card-agrivall">
                        <div class="card-body p-4">
                            <h5 class="heading-4 text-earth mb-3">Resumen</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Líneas</span>
                                <span>{{ count($productos) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Cantidades</span>
                                <span>
                                    {{ collect($productos)->map(fn($item) => $formatCantidad($item['cantidad'], $item['tipo_venta']) . ' ' . $item['unidad_medida'])->join(' · ') }}
                                </span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold fs-5">Total</span>
                                <span class="fw-bold fs-5 text-green">{{ number_format($total, 2) }} €</span>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="{{ route('pedidos.checkout') }}" class="btn btn-agrivall-primary">
                                    Proceder al pago
                                </a>
                                <form action="{{ route('carrito.clear') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-agrivall-outline btn-sm w-100"
                                        onclick="return confirm('¿Vaciar todo el carrito?')">
                                        Vaciar carrito
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection