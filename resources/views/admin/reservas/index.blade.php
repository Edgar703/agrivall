@extends('layouts.app')

@section('titol', 'Gestión de Reservas - Admin')

@section('contingut')
    <div class="animate-fadeInUp">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
            <div>
                <h1 class="heading-2 text-green mb-0 fs-3 fs-md-2">Panel de Administración — Reservas</h1>
                <p class="text-muted small mb-0 mt-1">Gestiona las solicitudes de reserva de la Casa Rural</p>
            </div>
        </div>

        {{-- Estadísticas --}}
        <div class="row g-2 g-md-3 mb-3 mb-md-4">
            @php
                $total        = $reservas->count();
                $preReserva   = $reservas->where('estado', 'PRE-RESERVA')->count();
                $reservado    = $reservas->where('estado', 'RESERVADO')->count();
                $noDisponible = $reservas->where('estado', 'NO_DISPONIBLE')->count();
                $canceladas   = $reservas->where('estado', 'cancelada')->count();
            @endphp
            <div class="col-6 col-md-3">
                <div class="card-agrivall bg-light">
                    <div class="card-body p-2 p-md-3">
                        <p class="text-muted mb-1 small">Total</p>
                        <h3 class="text-green mb-0 fs-5 fs-md-4">{{ $total }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card-agrivall" style="background:#fffbeb;">
                    <div class="card-body p-2 p-md-3">
                        <p class="text-muted mb-1 small">PRE-RESERVA</p>
                        <h3 class="mb-0 fs-5 fs-md-4" style="color:#b45309;">{{ $preReserva }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card-agrivall bg-light">
                    <div class="card-body p-2 p-md-3">
                        <p class="text-muted mb-1 small">Reservados</p>
                        <h3 class="text-success mb-0 fs-5 fs-md-4">{{ $reservado }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card-agrivall bg-light">
                    <div class="card-body p-2 p-md-3">
                        <p class="text-muted mb-1 small">Canceladas</p>
                        <h3 class="text-danger mb-0 fs-5 fs-md-4">{{ $canceladas }}</h3>
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

        @if ($reservas->isEmpty())
            <div class="alert alert-info" role="alert">
                <strong>Sin reservas</strong> — No hay reservas registradas aún.
            </div>
        @else

            {{-- Vista móvil: Cards --}}
            <div class="d-md-none">
                @foreach ($reservas as $reserva)
                    <div class="card-agrivall mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="fw-bold text-green mb-1">Reserva #{{ $reserva->id }}</h5>
                                    <p class="text-muted small mb-0">{{ $reserva->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                {{-- Badge estado --}}
                                @include('admin.reservas._estado_badge', ['estado' => $reserva->estado])
                            </div>

                            <div class="border-bottom pb-2 mb-2">
                                <p class="mb-1">
                                    <span class="text-muted small">Cliente:</span><br>
                                    <strong>{{ $reserva->usuario->name }}</strong><br>
                                    <small class="text-muted">{{ $reserva->usuario->email }}</small>
                                </p>
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <p class="text-muted small mb-0">Fechas:</p>
                                    <p class="fw-semibold mb-0 small">
                                        {{ optional($reserva->fecha_inicio)->format('d/m/Y') }}<br>
                                        {{ optional($reserva->fecha_fin)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-muted small mb-0">Personas:</p>
                                    <p class="fw-semibold mb-0">{{ $reserva->num_personas }}</p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <p class="text-muted small mb-0">Precio Total:</p>
                                <p class="text-green fw-bold mb-0 fs-5">{{ number_format($reserva->precio_total, 2) }} €</p>
                            </div>

                            @if ($reserva->comentario)
                                <div class="mb-3">
                                    <p class="text-muted small mb-0">Observaciones:</p>
                                    <p class="small mb-0 fst-italic">{{ $reserva->comentario }}</p>
                                </div>
                            @endif

                            {{-- Acciones de cambio de estado --}}
                            @include('admin.reservas._acciones_estado', ['reserva' => $reserva])
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
                            <th>Fechas</th>
                            <th>Noches</th>
                            <th>Personas</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Solicitada</th>
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
                                        {{ optional($reserva->fecha_inicio)->format('d/m/Y') }} —
                                        {{ optional($reserva->fecha_fin)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    {{ optional($reserva->fecha_inicio) && optional($reserva->fecha_fin)
                                        ? $reserva->fecha_fin->diffInDays($reserva->fecha_inicio)
                                        : '—' }}
                                </td>
                                <td class="text-center">{{ $reserva->num_personas }}</td>
                                <td class="text-green fw-semibold">{{ number_format($reserva->precio_total, 2) }} €</td>
                                <td>
                                    @include('admin.reservas._estado_badge', ['estado' => $reserva->estado])
                                </td>
                                <td class="text-muted small">{{ $reserva->created_at->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    @include('admin.reservas._acciones_estado', ['reserva' => $reserva])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
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
