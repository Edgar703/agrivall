@extends('layouts.app')

@section('titol', 'Detalle de Reserva #' . $reserva->id)

@section('contingut')
    <div class="container py-4 animate-fadeInUp">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="heading-2 text-green mb-2" style="font-size: 2rem; font-weight: 700;">Reserva #{{ $reserva->id }}
                </h1>
                <p class="text-muted mb-0" style="font-size: 0.95rem;">Detalles de tu reserva</p>
            </div>
            <div class="d-flex gap-2">
                @auth
                    @if(auth()->user()->id === $reserva->user_id && $reserva->estado !== 'cancelada')
                        <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger px-4"
                                onclick="return confirm('¿Estás seguro de que deseas cancelar esta reserva?')">
                                Cancelar Reserva
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('admin.reservas.index') }}" class="btn btn-secondary px-4">
                        Volver a Reservas
                    </a>
                @endauth
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-slideUp" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Información General -->
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header bg-white py-3 px-4" style="border-bottom: 2px solid #f0f0f0;">
                        <h5 class="mb-0 fw-bold" style="color: #2c3e50; font-size: 1.1rem;">Información General</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4 mb-3">
                            <div class="col-sm-6">
                                <p class="text-muted mb-2 small text-uppercase"
                                    style="letter-spacing: 0.5px; font-weight: 600;">Estado de Reserva</p>
                                <div>
                                    @if($reserva->estado === 'confirmada')
                                        <span class="badge px-3 py-2"
                                            style="background-color: #10b981; font-size: 0.9rem; font-weight: 600;">Confirmada</span>
                                    @elseif($reserva->estado === 'pendiente')
                                        <span class="badge px-3 py-2"
                                            style="background-color: #f59e0b; font-size: 0.9rem; font-weight: 600;">Pendiente de
                                            Aprobación</span>
                                    @elseif($reserva->estado === 'cancelada')
                                        <span class="badge bg-danger px-3 py-2"
                                            style="font-size: 0.9rem; font-weight: 600;">Cancelada</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <p class="text-muted mb-2 small text-uppercase"
                                    style="letter-spacing: 0.5px; font-weight: 600;">Fecha de Reserva</p>
                                <p class="fw-semibold mb-0" style="font-size: 1rem; color: #374151;">
                                    {{ $reserva->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                        <hr class="my-3" style="border-color: #e5e7eb;">
                        <div class="row g-4">
                            <div class="col-sm-6">
                                <p class="text-muted mb-2 small text-uppercase"
                                    style="letter-spacing: 0.5px; font-weight: 600;">Huésped</p>
                                <p class="fw-semibold mb-0" style="font-size: 1rem; color: #374151;">
                                    {{ $reserva->usuario->name }}
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <p class="text-muted mb-2 small text-uppercase"
                                    style="letter-spacing: 0.5px; font-weight: 600;">Email</p>
                                <p class="fw-semibold mb-0" style="font-size: 1rem; color: #374151;">
                                    {{ $reserva->usuario->email }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fechas de Estancia -->
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header bg-white py-3 px-4" style="border-bottom: 2px solid #f0f0f0;">
                        <h5 class="mb-0 fw-bold" style="color: #2c3e50; font-size: 1.1rem;">Fechas de Estancia</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-sm-6">
                                <p class="text-muted mb-2 small text-uppercase"
                                    style="letter-spacing: 0.5px; font-weight: 600;">Fecha de Inicio</p>
                                <p class="fw-semibold mb-0" style="font-size: 1.05rem; color: #374151;">
                                    {{ optional($reserva->fecha_inicio)->format('d/m/Y') }}
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <p class="text-muted mb-2 small text-uppercase"
                                    style="letter-spacing: 0.5px; font-weight: 600;">Fecha de Fin</p>
                                <p class="fw-semibold mb-0" style="font-size: 1.05rem; color: #374151;">
                                    {{ optional($reserva->fecha_fin)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalles de Huéspedes -->
                <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header bg-white py-3 px-4" style="border-bottom: 2px solid #f0f0f0;">
                        <h5 class="mb-0 fw-bold" style="color: #2c3e50; font-size: 1.1rem;">Detalles de Huéspedes</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4 mb-3">
                            <div class="col-sm-6">
                                <p class="text-muted mb-2 small text-uppercase"
                                    style="letter-spacing: 0.5px; font-weight: 600;">Número de Personas</p>
                                <p class="fw-bold mb-0" style="font-size: 1.5rem; color: #374151;">
                                    {{ $reserva->num_personas }}
                                </p>
                                <p class="text-muted mt-1 small">
                                    Multiplicador:
                                    <span class="fw-semibold">
                                        {{ number_format(1 + (($reserva->num_personas - 1) * 0.10), 2) }}x
                                    </span>
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <p class="text-muted mb-2 small text-uppercase"
                                    style="letter-spacing: 0.5px; font-weight: 600;">Precio por Noche</p>
                                <p class="fw-bold mb-0" style="font-size: 1.5rem; color: #10b981;">
                                    ${{ number_format($reserva->precio_por_noche ?? 50, 2) }}
                                </p>
                            </div>
                        </div>
                        <div class="row g-4 mb-3">
                            <div class="col-sm-6">
                                <p class="text-muted mb-2 small text-uppercase"
                                    style="letter-spacing: 0.5px; font-weight: 600;">Número de Noches</p>
                                <p class="fw-bold mb-0" style="font-size: 1.2rem; color: #374151;">
                                    {{ $reserva->num_noches }} @if($reserva->num_noches == 1) noche @else noches @endif
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <p class="text-muted mb-2 small text-uppercase"
                                    style="letter-spacing: 0.5px; font-weight: 600;">Precio Total</p>
                                <p class="fw-bold mb-0 text-green" style="font-size: 1.5rem;">
                                    ${{ number_format($reserva->calcularPrecioTotal(), 2) }}</p>
                            </div>
                        </div>
                        @if($reserva->comentario)
                            <hr class="my-3" style="border-color: #e5e7eb;">
                            <p class="text-muted mb-2 small text-uppercase" style="letter-spacing: 0.5px; font-weight: 600;">
                                Comentarios Adicionales</p>
                            <p class="mb-0" style="font-size: 0.95rem; color: #4b5563; line-height: 1.6;">
                                {{ $reserva->comentario }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Resumen -->
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header bg-white py-3 px-4" style="border-bottom: 2px solid #f0f0f0;">
                        <h5 class="mb-0 fw-bold" style="color: #2c3e50; font-size: 1.1rem;">Resumen</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-2 pb-2">
                            <span class="text-muted small">Precio por noche:</span>
                            <strong
                                style="color: #374151;">${{ number_format($reserva->precio_por_noche ?? 50, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Número de noches:</span>
                            <strong style="color: #374151;">{{ $reserva->num_noches }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Personas:</span>
                            <strong style="color: #374151;">{{ $reserva->num_personas }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted small">Multiplicador (+10% por persona):</span>
                            <strong
                                style="color: #10b981;">{{ number_format(1 + (($reserva->num_personas - 1) * 0.10), 2) }}x</strong>
                        </div>
                        <hr class="my-3" style="border-color: #e5e7eb;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold" style="font-size: 1.1rem; color: #374151;">Total:</span>
                            <strong class="text-green"
                                style="font-size: 1.5rem;">${{ number_format($reserva->calcularPrecioTotal(), 2) }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Estado de la Reserva -->
                @if($reserva->estado === 'confirmada')
                    <div class="alert alert-success border-0 shadow-sm mb-4" role="alert"
                        style="border-radius: 12px; background-color: #d1fae5; border-left: 4px solid #10b981 !important;">
                        <div class="d-flex align-items-start">
                            <div class="me-3" style="font-size: 1.5rem;">✓</div>
                            <div>
                                <strong class="d-block mb-2" style="color: #065f46; font-size: 1.05rem;">Confirmada</strong>
                                <p class="mb-0 small" style="color: #047857; line-height: 1.5;">Tu reserva está confirmada. Te
                                    hemos enviado un email con los detalles.</p>
                            </div>
                        </div>
                    </div>
                @elseif($reserva->estado === 'pendiente')
                    <div class="alert alert-warning border-0 shadow-sm mb-4" role="alert"
                        style="border-radius: 12px; background-color: #fef3c7; border-left: 4px solid #f59e0b !important;">
                        <div class="d-flex align-items-start">
                            <div class="me-3" style="font-size: 1.5rem;">⏱</div>
                            <div>
                                <strong class="d-block mb-2" style="color: #92400e; font-size: 1.05rem;">Pendiente</strong>
                                <p class="mb-0 small" style="color: #b45309; line-height: 1.5;">Tu reserva está en espera de
                                    aprobación. Te notificaremos cuando sea confirmada.</p>
                            </div>
                        </div>
                    </div>
                @elseif($reserva->estado === 'cancelada')
                    <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert"
                        style="border-radius: 12px; background-color: #fee2e2; border-left: 4px solid #ef4444 !important;">
                        <div class="d-flex align-items-start">
                            <div class="me-3" style="font-size: 1.5rem;">✗</div>
                            <div>
                                <strong class="d-block mb-2" style="color: #991b1b; font-size: 1.05rem;">Cancelada</strong>
                                <p class="mb-0 small" style="color: #dc2626; line-height: 1.5;">Esta reserva ha sido cancelada.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Acciones -->
                <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header bg-white py-3 px-4" style="border-bottom: 2px solid #f0f0f0;">
                        <h5 class="mb-0 fw-bold" style="color: #2c3e50; font-size: 1.1rem;">Acciones</h5>
                    </div>
                    <div class="card-body p-4">
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <div class="d-grid gap-3">
                                    <a href="{{ route('reservas.edit', $reserva->id) }}" class="btn btn-warning py-2 fw-semibold"
                                        style="border-radius: 8px; font-size: 0.95rem;">
                                        📝 Editar Reserva
                                    </a>
                                    @if($reserva->estado !== 'cancelada')
                                        <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold"
                                                style="border-radius: 8px; font-size: 0.95rem;"
                                                onclick="return confirm('¿Cancelar esta reserva?')">
                                                🗑️ Cancelar Reserva
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @elseif(auth()->user()->id === $reserva->user_id && $reserva->estado !== 'cancelada')
                                <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold"
                                        style="border-radius: 8px; font-size: 0.95rem;"
                                        onclick="return confirm('¿Estás seguro de que deseas cancelar esta reserva?')">
                                        🗑️ Cancelar Reserva
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection