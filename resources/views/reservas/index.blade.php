@extends('layouts.app')

@section('titol', 'Mis Reservas')

@section('contingut')
    <div class="animate-fadeInUp">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
            <div>
                <h1 class="heading-2 text-green mb-0 fs-3 fs-md-2">
                    @auth
                        @if (auth()->user()->role === 'admin')
                            Gestión de Reservas
                        @else
                            Mis Reservas
                        @endif
                    @endauth
                </h1>
            </div>
            @auth
                @if (auth()->user()->role !== 'admin')
                    <a href="{{ route('reservas.create') }}" class="btn btn-agrivall-primary btn-sm">
                        + Nueva Reserva
                    </a>
                @endif
            @endauth
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

        @if ($reservas->isEmpty())
            <div class="alert alert-info" role="alert">
                <strong>Sin reservas</strong>
                @auth
                    @if (auth()->user()->role === 'admin')
                        No hay reservas registradas aún.
                    @else
                        Aún no tienes reservas. <a href="{{ route('reservas.create') }}">¡Crea una ahora!</a>
                    @endif
                @endauth
            </div>
        @else
            {{-- Vista móvil: Cards --}}
            <div class="d-md-none">
                @foreach ($reservas as $reserva)
                    <div class="card-agrivall mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold text-green mb-0">Reserva #{{ $reserva->id }}</h5>
                                @if ($reserva->estado === 'RESERVADO')
                                    <span class="badge bg-success">RESERVADO</span>
                                @elseif($reserva->estado === 'PRE-RESERVA')
                                    <span class="badge bg-warning text-dark">PRE-RESERVA</span>
                                @elseif($reserva->estado === 'NO_DISPONIBLE')
                                    <span class="badge bg-secondary">NO DISPONIBLE</span>
                                @elseif($reserva->estado === 'cancelada')
                                    <span class="badge bg-danger">CANCELADA</span>
                                @endif
                            </div>

                            @auth
                                @if (auth()->user()->role === 'admin')
                                    <div class="mb-2 pb-2 border-bottom">
                                        <p class="text-muted small mb-0">Usuario:</p>
                                        <p class="fw-semibold mb-0">{{ $reserva->usuario->name ?? 'Usuario no disponible' }}</p>
                                    </div>
                                @endif
                            @endauth

                            <div class="row g-2 mb-2">
                                <div class="col-12">
                                    <p class="text-muted small mb-0">Fechas:</p>
                                    <p class="fw-semibold mb-0 small">
                                        {{ optional($reserva->fecha_inicio)->format('d/m/Y') }} -
                                        {{ optional($reserva->fecha_fin)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-muted small mb-0">Personas:</p>
                                    <p class="fw-semibold mb-0">{{ $reserva->num_personas }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-muted small mb-0">Precio Total:</p>
                                    <p class="text-green fw-bold mb-0">${{ number_format($reserva->precio_total, 2) }}</p>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ route('reservas.show', $reserva->id) }}" class="btn btn-info btn-sm flex-fill">
                                    Ver
                                </a>
                                @auth
                                    @if (auth()->user()->role === 'admin')
                                        <a href="{{ route('reservas.edit', $reserva->id) }}"
                                            class="btn btn-warning btn-sm flex-fill">
                                            Editar
                                        </a>
                                    @elseif(auth()->user()->id === $reserva->user_id && $reserva->estado !== 'cancelada')
                                        <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST"
                                            class="flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm w-100"
                                                onclick="return confirm('¿Estás seguro de que deseas cancelar esta reserva?')">
                                                Cancelar
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
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
                            @auth
                                @if (auth()->user()->role === 'admin')
                                    <th>Usuario</th>
                                @endif
                            @endauth
                            <th>Fechas</th>
                            <th>Personas</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservas as $reserva)
                            <tr class="transition-colors">
                                <td class="fw-semibold">#{{ $reserva->id }}</td>
                                @auth
                                    @if (auth()->user()->role === 'admin')
                                        <td>{{ $reserva->usuario->name ?? 'Usuario no disponible' }}</td>
                                    @endif
                                @endauth
                                <td>
                                    <span class="fw-medium">
                                        {{ optional($reserva->fecha_inicio)->format('d/m/Y') }} -
                                        {{ optional($reserva->fecha_fin)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $reserva->num_personas }}</td>
                                <td class="text-green fw-semibold">${{ number_format($reserva->precio_total, 2) }}</td>
                                <td>
                                    @if ($reserva->estado === 'confirmada')
                                        <span class="badge bg-success">Confirmada</span>
                                    @elseif($reserva->estado === 'pendiente')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @elseif($reserva->estado === 'cancelada')
                                        <span class="badge bg-danger">Cancelada</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('reservas.show', $reserva->id) }}" class="btn btn-sm btn-info">
                                        Ver
                                    </a>
                                    @auth
                                        @if (auth()->user()->role === 'admin')
                                            <a href="{{ route('reservas.edit', $reserva->id) }}"
                                                class="btn btn-sm btn-warning">
                                                Editar
                                            </a>
                                        @elseif(auth()->user()->id === $reserva->user_id && $reserva->estado !== 'cancelada')
                                            <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('¿Estás seguro de que deseas cancelar esta reserva?')">
                                                    Cancelar
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
