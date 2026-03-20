@extends('layouts.app')

@section('titol', 'Mis Pedidos')

@section('contingut')
    <div class="animate-fadeInUp">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="heading-2 text-green mb-1">Mis Pedidos</h1>
                <p class="text-muted mb-0">Historial de tus compras</p>
            </div>
            <a href="{{ route('productos.catalogo') }}" class="btn btn-agrivall-outline btn-sm">← Ir al Catálogo</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-slideUp" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($pedidos->isEmpty())
            <div class="text-center py-5">
                <h3 class="heading-4 text-muted">No tienes pedidos aún</h3>
                <p class="text-muted mb-3">Explora nuestro catálogo y realiza tu primer pedido</p>
                <a href="{{ route('productos.catalogo') }}" class="btn btn-agrivall-primary">Ver Catálogo</a>
            </div>
        @else
            {{-- Vista móvil: Cards --}}
            <div class="d-md-none">
                @foreach ($pedidos as $pedido)
                    <div class="card-agrivall mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold text-green mb-1">Pedido #{{ $pedido->id }}</h6>
                                    <small class="text-muted">{{ $pedido->fecha_pedido->format('d/m/Y H:i') }}</small>
                                </div>
                                @php
                                    $badgeClass = match ($pedido->estado) {
                                        'Iniciado' => 'bg-warning text-dark',
                                        'En proceso' => 'bg-info',
                                        'Reparto' => 'bg-primary',
                                        'Finalizado' => 'bg-success',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $pedido->estado }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-green fs-5">{{ number_format($pedido->precio_pedido, 2) }}
                                    €</span>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('pedidos.show', $pedido) }}"
                                        class="btn btn-agrivall-primary btn-sm">Ver detalle</a>
                                    <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST"
                                        onsubmit="return confirm('\u00bfEliminar pedido #{{ $pedido->id }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>

            {{-- Vista desktop: Tabla --}}
            <div class="table-agrivall d-none d-md-block">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Fecha</th>
                            <th>Método Pago</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedidos as $pedido)
                            <tr>
                                <td class="fw-semibold">#{{ $pedido->id }}</td>
                                <td>{{ $pedido->fecha_pedido->format('d/m/Y H:i') }}</td>
                                <td>{{ $pedido->metodo_pago }}</td>
                                <td class="text-center fw-bold text-green">{{ number_format($pedido->precio_pedido, 2) }} €
                                </td>
                                <td class="text-center">
                                    @php
                                        $badgeClass = match ($pedido->estado) {
                                            'Iniciado' => 'bg-warning text-dark',
                                            'En proceso' => 'bg-info',
                                            'Reparto' => 'bg-primary',
                                            'Finalizado' => 'bg-success',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $pedido->estado }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-1 justify-content-end">
                                        <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-info btn-sm">Ver
                                            detalle</a>
                                        <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST"
                                            onsubmit="return confirm('\u00bfEliminar pedido #{{ $pedido->id }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
