@extends('layouts.app')

@section('titol', 'Pedido #' . $pedido->id . ' - Admin')

@section('contingut')
    <div class="animate-fadeInUp">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.pedidos.index') }}" class="text-green">Gestión
                                Pedidos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pedido #{{ $pedido->id }}</li>
                    </ol>
                </nav>
                <h1 class="heading-2 text-green mb-0">Pedido #{{ $pedido->id }}</h1>
            </div>
            <div class="d-flex gap-2 align-items-center">
                @php
                    $badgeClass = match ($pedido->estado) {
                        'Iniciado' => 'bg-warning text-dark',
                        'En proceso' => 'bg-info',
                        'Reparto' => 'bg-primary',
                        'Finalizado' => 'bg-success',
                        default => 'bg-secondary',
                    };
                @endphp
                <div class="dropdown">
                    <span class="badge {{ $badgeClass }} fs-6 px-3 py-2 dropdown-toggle" role="button"
                        data-bs-toggle="dropdown">
                        {{ $pedido->estado }}
                    </span>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach (['Iniciado', 'En proceso', 'Reparto', 'Finalizado'] as $estado)
                            <li>
                                <form action="{{ route('admin.pedidos.cambiarEstado', $pedido->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="estado" value="{{ $estado }}">
                                    <button type="submit" class="dropdown-item">
                                        {{ $estado }}
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <a href="{{ route('admin.pedidos.index') }}" class="btn btn-agrivall-secondary btn-sm">← Volver</a>
                <form action="{{ route('admin.pedidos.destroy', $pedido->id) }}" method="POST"
                    onsubmit="return confirm('\u00bfEliminar pedido #{{ $pedido->id }}? Esta acción no se puede deshacer.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar pedido</button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-slideUp" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            {{-- Datos del cliente --}}
            <div class="col-lg-6">
                <div class="card-agrivall h-100">
                    <div class="card-body p-4">
                        <h5 class="heading-4 text-earth mb-3">Datos del cliente</h5>

                        <div class="mb-3 p-3 bg-natural rounded">
                            <span class="text-muted small">Nombre</span>
                            <p class="mb-0 fw-semibold">{{ $pedido->nombre_cliente }}</p>
                        </div>

                        <div class="mb-3 p-3 bg-natural rounded">
                            <span class="text-muted small">Email</span>
                            <p class="mb-0 fw-semibold">{{ $pedido->email_cliente }}</p>
                        </div>

                        <div class="mb-3 p-3 bg-natural rounded">
                            <span class="text-muted small">Teléfono</span>
                            <p class="mb-0 fw-semibold">{{ $pedido->tlf_cliente }}</p>
                        </div>

                        @if ($pedido->usuario)
                            <div class="mb-3 p-3 bg-natural rounded">
                                <span class="text-muted small">Usuario registrado</span>
                                <p class="mb-0">
                                    <a href="{{ route('admin.usuarios.show', $pedido->usuario->id) }}"
                                        class="text-green fw-semibold">
                                        {{ $pedido->usuario->name }} ({{ $pedido->usuario->email }})
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Datos del pedido --}}
            <div class="col-lg-6">
                <div class="card-agrivall h-100">
                    <div class="card-body p-4">
                        <h5 class="heading-4 text-earth mb-3">Datos del pedido</h5>

                        <div class="mb-3 p-3 bg-natural rounded">
                            <span class="text-muted small">Fecha del pedido</span>
                            <p class="mb-0 fw-semibold">{{ $pedido->fecha_pedido->format('d/m/Y H:i') }}</p>
                        </div>

                        <div class="mb-3 p-3 bg-natural rounded">
                            <span class="text-muted small">Método de pago</span>
                            <p class="mb-0 fw-semibold">{{ $pedido->metodo_pago }}</p>
                        </div>

                        <div class="mb-3 p-3 bg-natural rounded">
                            <span class="text-muted small">Dirección de envío</span>
                            <p class="mb-0 fw-semibold">{{ $pedido->direccion_envio }}</p>
                        </div>

                        <div class="p-3 bg-natural rounded">
                            <span class="text-muted small">Total del pedido</span>
                            <p class="mb-0 fw-bold text-green fs-4">{{ number_format($pedido->precio_pedido, 2) }} €</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Líneas del pedido --}}
        <div class="card-agrivall mt-4">
            <div class="card-body p-4">
                <h5 class="heading-4 text-earth mb-3">Productos del pedido</h5>

                {{-- Vista móvil --}}
                <div class="d-md-none">
                    @foreach ($pedido->lineas as $linea)
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <div>
                                <span class="fw-semibold">{{ $linea->producto?->nombre ?? 'Producto eliminado' }}</span>
                                <small class="d-block text-muted">
                                    {{ $linea->cantidad }} × {{ number_format($linea->precio_unitario, 2) }} €
                                </small>
                            </div>
                            <span class="fw-bold">{{ number_format($linea->subtotal, 2) }} €</span>
                        </div>
                    @endforeach
                </div>

                {{-- Vista desktop --}}
                <div class="d-none d-md-block">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Precio Ud.</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedido->lineas as $linea)
                                <tr>
                                    <td class="fw-semibold">{{ $linea->producto?->nombre ?? 'Producto eliminado' }}</td>
                                    <td class="text-center">{{ number_format($linea->precio_unitario, 2) }} €</td>
                                    <td class="text-center">{{ $linea->cantidad }}</td>
                                    <td class="text-center fw-bold text-green">{{ number_format($linea->subtotal, 2) }} €
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-top">
                                <td colspan="3" class="text-end fw-bold fs-5">Total</td>
                                <td class="text-center fw-bold fs-5 text-green">
                                    {{ number_format($pedido->precio_pedido, 2) }} €</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
