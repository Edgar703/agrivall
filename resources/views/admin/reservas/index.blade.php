@extends('layouts.app')

@section('titol', 'Gestión de Reservas - Admin')

@section('contingut')
    <div class="animate-fadeInUp">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="heading-2 text-green mb-0">Panel de Administración - Reservas</h1>
            </div>
            <a href="{{ route('reservas.index') }}" class="btn btn-agrivall-secondary">
                ← Volver
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card-agrivall bg-light">
                    <div class="card-body">
                        <p class="text-muted mb-1">Total de Reservas</p>
                        <h3 class="text-green mb-0">{{ $reservas->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-agrivall bg-light">
                    <div class="card-body">
                        <p class="text-muted mb-1">Confirmadas</p>
                        <h3 class="text-success mb-0">{{ $reservas->where('estado', 'confirmada')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-agrivall bg-light">
                    <div class="card-body">
                        <p class="text-muted mb-1">Pendientes</p>
                        <h3 class="text-warning mb-0">{{ $reservas->where('estado', 'pendiente')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-agrivall bg-light">
                    <div class="card-body">
                        <p class="text-muted mb-1">Canceladas</p>
                        <h3 class="text-danger mb-0">{{ $reservas->where('estado', 'cancelada')->count() }}</h3>
                    </div>
                </div>
            </div>
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

        @if($reservas->isEmpty())
            <div class="alert alert-info" role="alert">
                <strong>Sin reservas</strong> - No hay reservas registradas aún.
            </div>
        @else
            <div class="table-agrivall">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Fechas</th>
                            <th>Personas</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Fecha Reserva</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservas as $reserva)
                            <tr class="transition-colors">
                                <td class="fw-semibold">#{{ $reserva->id }}</td>
                                <td>
                                    <div class="fw-medium">{{ $reserva->usuario->name }}</div>
                                    <small class="text-muted">{{ $reserva->usuario->email }}</small>
                                </td>
                                <td>
                                    <span class="fw-medium">
                                        {{ optional($reserva->fecha_inicio)->format('d/m/Y') }} -
                                        {{ optional($reserva->fecha_fin)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $reserva->num_personas }}</td>
                                <td class="text-green fw-semibold">${{ number_format($reserva->precio_total, 2) }}</td>
                                <td>
                                    <div class="dropdown">
                                        @if($reserva->estado === 'confirmada')
                                            <span class="badge bg-success dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                                Confirmada
                                            </span>
                                        @elseif($reserva->estado === 'pendiente')
                                            <span class="badge bg-warning text-dark dropdown-toggle" role="button"
                                                data-bs-toggle="dropdown">
                                                Pendiente
                                            </span>
                                        @elseif($reserva->estado === 'cancelada')
                                            <span class="badge bg-danger dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                                Cancelada
                                            </span>
                                        @endif

                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <form action="{{ route('reservas.cambiarEstado', $reserva->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="confirmada">
                                                    <button type="submit" class="dropdown-item">Confirmar</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('reservas.cambiarEstado', $reserva->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="pendiente">
                                                    <button type="submit" class="dropdown-item">Marcar Pendiente</button>
                                                </form>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form action="{{ route('reservas.cambiarEstado', $reserva->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="cancelada">
                                                    <button type="submit" class="dropdown-item text-danger"
                                                        onclick="return confirm('¿Cancelar esta reserva?')">
                                                        Cancelar
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td class="text-muted small">{{ $reserva->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm gap-2">
                                        <a href="{{ route('reservas.show', $reserva->id) }}" class="btn btn-info rounded">Ver</a>
                                        <a href="{{ route('reservas.edit', $reserva->id) }}"
                                            class="btn btn-warning rounded">Editar</a>
                                        <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No hay reservas registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        @endif
    </div>
@endsection