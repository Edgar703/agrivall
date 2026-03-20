@extends('layouts.app')

@section('titol', 'Gestión de Pedidos - Admin')

@section('contingut')
    <div class="animate-fadeInUp">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
            <div>
                <h1 class="heading-2 text-green mb-0 fs-3 fs-md-2">Panel de Administración - Pedidos</h1>
            </div>
        </div>

        {{-- Estadísticas --}}
        <div class="row g-2 g-md-3 mb-3 mb-md-4">
            <div class="col-6 col-md">
                <div class="card-agrivall bg-light">
                    <div class="card-body p-2 p-md-3">
                        <p class="text-muted mb-1 small">Total</p>
                        <h3 class="text-green mb-0 fs-5 fs-md-4">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md">
                <div class="card-agrivall bg-light">
                    <div class="card-body p-2 p-md-3">
                        <p class="text-muted mb-1 small">Iniciados</p>
                        <h3 class="text-warning mb-0 fs-5 fs-md-4">{{ $stats['iniciados'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md">
                <div class="card-agrivall bg-light">
                    <div class="card-body p-2 p-md-3">
                        <p class="text-muted mb-1 small">En proceso</p>
                        <h3 class="text-info mb-0 fs-5 fs-md-4">{{ $stats['en_proceso'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md">
                <div class="card-agrivall bg-light">
                    <div class="card-body p-2 p-md-3">
                        <p class="text-muted mb-1 small">Reparto</p>
                        <h3 class="text-primary mb-0 fs-5 fs-md-4">{{ $stats['reparto'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md">
                <div class="card-agrivall bg-light">
                    <div class="card-body p-2 p-md-3">
                        <p class="text-muted mb-1 small">Finalizados</p>
                        <h3 class="text-success mb-0 fs-5 fs-md-4">{{ $stats['finalizados'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filtros --}}
        <div class="card-agrivall mb-3">
            <div class="card-body p-3">
                <form action="{{ route('admin.pedidos.index') }}" method="GET" class="row g-2 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label-agrivall small">Buscar</label>
                        <input type="text" name="q" class="form-control-agrivall form-control-sm"
                            value="{{ request('q') }}" placeholder="Nombre, email o ID del pedido">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label-agrivall small">Estado</label>
                        <select name="estado" class="form-control-agrivall form-control-sm">
                            <option value="">Todos</option>
                            @foreach (['Iniciado', 'En proceso', 'Reparto', 'Finalizado'] as $estado)
                                <option value="{{ $estado }}" {{ request('estado') === $estado ? 'selected' : '' }}>
                                    {{ $estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-agrivall-primary btn-sm">Filtrar</button>
                        <a href="{{ route('admin.pedidos.index') }}" class="btn btn-agrivall-outline btn-sm">Limpiar</a>
                    </div>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-slideUp" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($pedidos->isEmpty())
            <div class="alert alert-info" role="alert">
                <strong>Sin pedidos</strong> - No hay pedidos que coincidan con los filtros.
            </div>
        @else
            {{-- Vista móvil: Cards --}}
            <div class="d-md-none">
                @foreach ($pedidos as $pedido)
                    <div class="card-agrivall mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="fw-bold text-green mb-1">Pedido #{{ $pedido->id }}</h5>
                                    <p class="text-muted small mb-0">{{ $pedido->fecha_pedido->format('d/m/Y H:i') }}</p>
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

                            <div class="border-bottom pb-2 mb-2">
                                <p class="mb-1">
                                    <span class="text-muted small">Cliente:</span><br>
                                    <strong>{{ $pedido->nombre_cliente }}</strong><br>
                                    <small class="text-muted">{{ $pedido->email_cliente }}</small>
                                </p>
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <p class="text-muted small mb-0">Método pago:</p>
                                    <p class="fw-semibold mb-0 small">{{ $pedido->metodo_pago }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-muted small mb-0">Productos:</p>
                                    <p class="fw-semibold mb-0">{{ $pedido->lineas_count }}</p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <p class="text-muted small mb-0">Total:</p>
                                <p class="text-green fw-bold mb-0 fs-5">{{ number_format($pedido->precio_pedido, 2) }} €
                                </p>
                            </div>

                            <a href="{{ route('admin.pedidos.show', $pedido->id) }}"
                                class="btn btn-info btn-sm w-100 mb-2">Ver
                                Detalle</a>
                            <form action="{{ route('admin.pedidos.destroy', $pedido->id) }}" method="POST"
                                onsubmit="return confirm('\u00bfEliminar pedido #{{ $pedido->id }}? Esta acción no se puede deshacer.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Vista desktop: Tabla --}}
            <div class="table-agrivall d-none d-md-block">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th class="text-center">Productos</th>
                            <th class="text-center">Total</th>
                            <th>Método Pago</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedidos as $pedido)
                            <tr>
                                <td class="fw-semibold">#{{ $pedido->id }}</td>
                                <td>
                                    <div class="fw-medium">{{ $pedido->nombre_cliente }}</div>
                                    <small class="text-muted">{{ $pedido->email_cliente }}</small>
                                </td>
                                <td class="text-muted small">{{ $pedido->fecha_pedido->format('d/m/Y H:i') }}</td>
                                <td class="text-center">{{ $pedido->lineas_count }}</td>
                                <td class="text-center text-green fw-semibold">
                                    {{ number_format($pedido->precio_pedido, 2) }} €</td>
                                <td>{{ $pedido->metodo_pago }}</td>
                                <td>
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
                                        <a href="{{ route('admin.pedidos.show', $pedido->id) }}"
                                            class="btn btn-info btn-sm rounded">Ver</a>
                                        <form action="{{ route('admin.pedidos.destroy', $pedido->id) }}" method="POST"
                                            onsubmit="return confirm('\u00bfEliminar pedido #{{ $pedido->id }}? Esta acción no se puede deshacer.')">
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

            {{-- Paginación --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $pedidos->links() }}
            </div>
        @endif
    </div>
@endsection
