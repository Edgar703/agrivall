@extends('layouts.app')

@section('titol', 'Pedido #' . $pedido->id)

@section('contingut')
    @php
        $formatCantidad = function ($cantidad, $tipoVenta) {
            return $tipoVenta === 'peso'
                ? number_format((float) $cantidad, 2, ',', '')
                : number_format((float) $cantidad, 0, ',', '');
        };
    @endphp
    <div class="animate-fadeInUp">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('pedidos.misPedidos') }}" class="text-green">Mis Pedidos</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Pedido #{{ $pedido->id }}</li>
            </ol>
        </nav>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-slideUp" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="heading-2 text-green mb-0">Pedido #{{ $pedido->id }}</h1>
            @php
                $badgeClass = match ($pedido->estado) {
                    'Iniciado' => 'bg-warning text-dark',
                    'En proceso' => 'bg-info',
                    'Reparto' => 'bg-primary',
                    'Finalizado' => 'bg-success',
                    default => 'bg-secondary',
                };
            @endphp
            <span class="badge {{ $badgeClass }} fs-6 px-3 py-2">{{ $pedido->estado }}</span>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card-agrivall h-100">
                    <div class="card-body p-4">
                        <h5 class="heading-4 text-earth mb-3">Datos del pedido</h5>

                        <div class="mb-3 p-3 bg-natural rounded">
                            <span class="text-muted small">Fecha</span>
                            <p class="mb-0 fw-semibold">{{ $pedido->fecha_pedido->format('d/m/Y H:i') }}</p>
                        </div>

                        <div class="mb-3 p-3 bg-natural rounded">
                            <span class="text-muted small">Cliente</span>
                            <p class="mb-0 fw-semibold">{{ $pedido->nombre_cliente }}</p>
                            <small class="text-muted">{{ $pedido->email_cliente }} · {{ $pedido->tlf_cliente }}</small>
                        </div>

                        <div class="mb-3 p-3 bg-natural rounded">
                            <span class="text-muted small">Dirección de envío</span>
                            <p class="mb-0 fw-semibold">{{ $pedido->direccion_envio }}</p>
                        </div>

                        <div class="p-3 bg-natural rounded">
                            <span class="text-muted small">Método de pago</span>
                            <p class="mb-0 fw-semibold">{{ $pedido->metodo_pago }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card-agrivall h-100">
                    <div class="card-body p-4">
                        <h5 class="heading-4 text-earth mb-3">Productos</h5>

                        @foreach ($pedido->lineas as $linea)
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <div>
                                    <span
                                        class="fw-semibold">{{ $linea->nombre_producto ?: ($linea->producto?->nombre ?? 'Producto eliminado') }}</span>
                                    @if ($linea->nombre_variedad)
                                        <small class="d-block text-muted">Variedad: {{ $linea->nombre_variedad }}</small>
                                    @endif
                                    <small class="d-block text-muted">
                                        {{ $formatCantidad($linea->cantidad, $linea->tipo_venta) }} {{ $linea->unidad_medida }}
                                        ×
                                        {{ number_format($linea->precio_unitario, 2) }} €/{{ $linea->unidad_medida }}
                                    </small>
                                </div>
                                <span class="fw-bold">{{ number_format($linea->subtotal, 2) }} €</span>
                            </div>
                        @endforeach

                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold fs-5">Total</span>
                            <span class="fw-bold fs-5 text-green">{{ number_format($pedido->precio_pedido, 2) }} €</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="d-flex gap-2">
                <a href="{{ route('profile.edit') }}" class="btn btn-agrivall-outline">← Volver a Mi Cuenta</a>
                <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST"
                    onsubmit="return confirm('¿Eliminar pedido #{{ $pedido->id }}? Esta acción no se puede deshacer.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Eliminar pedido</button>
                </form>
            </div>
        </div>
    </div>
@endsection