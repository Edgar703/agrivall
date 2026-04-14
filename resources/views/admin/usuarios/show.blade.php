@extends('layouts.app')

@section('titol', 'Usuario #' . $usuario->id . ' - Admin')

@section('contingut')
    <div class="animate-fadeInUp">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
            <div>
                <h1 class="heading-2 text-green mb-0 fs-3 fs-md-2">Detalle de Usuario</h1>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn btn-warning btn-sm">Editar datos</a>
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-agrivall-secondary btn-sm">← Volver</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card-agrivall mb-4">
            <div class="card-body p-3 p-md-4">
                <h3 class="text-green mb-3">Datos del usuario</h3>
                <div class="row g-3">
                    <div class="col-md-4">
                        <p class="text-muted small mb-1">Nombre</p>
                        <p class="fw-semibold mb-0">{{ $usuario->name }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted small mb-1">Email</p>
                        <p class="fw-semibold mb-0">{{ $usuario->email }}</p>
                    </div>
                    <div class="col-md-2">
                        <p class="text-muted small mb-1">Rol</p>
                        @if ($usuario->role === 'admin')
                            <span class="badge bg-warning text-dark">Admin</span>
                        @else
                            <span class="badge bg-secondary">Usuario</span>
                        @endif
                    </div>
                    <div class="col-md-2">
                        <p class="text-muted small mb-1">ID</p>
                        <p class="fw-semibold mb-0">#{{ $usuario->id }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-agrivall mb-4">
            <div class="card-body p-3 p-md-4">
                <h3 class="text-green mb-3">Reservas</h3>

                @if ($reservas->isEmpty())
                    <div class="alert alert-info mb-0">Este usuario no tiene reservas todavía.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fechas</th>
                                    <th>Personas</th>
                                    <th>Estado</th>
                                    <th>Precio</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservas as $reserva)
                                    <tr>
                                        <td>#{{ $reserva->id }}</td>
                                        <td>
                                            {{ optional($reserva->fecha_inicio)->format('d/m/Y') }} -
                                            {{ optional($reserva->fecha_fin)->format('d/m/Y') }}
                                        </td>
                                        <td>{{ $reserva->num_personas }}</td>
                                        <td>
                                            @if ($reserva->estado === 'RESERVADO')
                                                <span class="badge bg-success">RESERVADO</span>
                                            @elseif($reserva->estado === 'PRE-RESERVA')
                                                <span class="badge bg-warning text-dark">PRE-RESERVA</span>
                                            @elseif($reserva->estado === 'NO_DISPONIBLE')
                                                <span class="badge bg-secondary">NO DISPONIBLE</span>
                                            @else
                                                <span class="badge bg-danger">CANCELADA</span>
                                            @endif
                                        </td>
                                        <td>${{ number_format($reserva->precio_total, 2) }}</td>
                                        <td>
                                            <a href="{{ route('reservas.show', $reserva->id) }}" class="btn btn-info btn-sm">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-agrivall">
            <div class="card-body p-3 p-md-4">
                <h3 class="text-green mb-3">Compras</h3>

                @if (!$comprasDisponibles)
                    <div class="alert alert-warning mb-0">
                        El sistema de compras todavía no está disponible para vincular pedidos con usuarios.
                    </div>
                @elseif($compras->isEmpty())
                    <div class="alert alert-info mb-0">
                        No hay compras asociadas al email de este usuario.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID pedido</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Método pago</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($compras as $compra)
                                    <tr>
                                        <td>#{{ $compra->id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($compra->fecha_pedido)->format('d/m/Y H:i') }}</td>
                                        <td>{{ $compra->estado }}</td>
                                        <td>{{ $compra->metodo_pago }}</td>
                                        <td>${{ number_format($compra->precio_pedido, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection