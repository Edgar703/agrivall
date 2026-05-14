<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    {{-- SECCIÓN DE DISPONIBILIDAD --}}
    <section id="disponibilidad" class="py-5">
        <div class="container">
            <h2 class="h3 fw-bold mb-2" style="color: var(--agrivall-gray-800);">Disponibilidad</h2>
            <p class="text-muted mb-4" style="max-width: 580px;">
                Consulta los períodos ocupados o pendientes antes de realizar tu solicitud de reserva.
                Las fechas sin reserva están disponibles.
            </p>

            {{-- Leyenda --}}
            <div class="d-flex flex-wrap gap-3 mb-4">
                <span class="badge bg-warning text-dark px-3 py-2">🕐 PRE-RESERVA</span>
                <span class="badge bg-success text-white px-3 py-2">✅ RESERVADO</span>
                <span class="badge bg-secondary text-white px-3 py-2">🚫 NO DISPONIBLE</span>
            </div>

            @if ($reservasActivas->isEmpty())
                <div class="alert alert-success" role="alert">
                    <strong>¡Buenas noticias!</strong> No hay reservas registradas próximamente. Todas las fechas están
                    disponibles.
                </div>
            @else
                {{-- Vista móvil: cards --}}
                <div class="d-md-none">
                    @foreach ($reservasActivas as $r)
                        @php
                            $badge = match ($r->estado) {
                                'PRE-RESERVA' => 'warning text-dark',
                                'RESERVADO' => 'success text-white',
                                'NO_DISPONIBLE' => 'secondary text-white',
                                default => 'light text-dark',
                            };
                            $label = match ($r->estado) {
                                'PRE-RESERVA' => 'PRE-RESERVA',
                                'RESERVADO' => 'RESERVADO',
                                'NO_DISPONIBLE' => 'NO DISPONIBLE',
                                default => $r->estado,
                            };
                            $noches = $r->fecha_inicio->diffInDays($r->fecha_fin);
                        @endphp
                        <div class="card-agrivall mb-2 p-3 d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <p class="fw-semibold mb-0 small">
                                    {{ $r->fecha_inicio->format('d M Y') }} — {{ $r->fecha_fin->format('d M Y') }}
                                </p>
                                <p class="text-muted mb-0" style="font-size:0.8em;">{{ $noches }}
                                    {{ $noches === 1 ? 'noche' : 'noches' }}</p>
                            </div>
                            <span class="badge bg-{{ $badge }}">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- Vista desktop: tabla --}}
                <div class="d-none d-md-block table-agrivall">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Desde</th>
                                <th>Hasta</th>
                                <th>Noches</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservasActivas as $r)
                                @php
                                    $badge = match ($r->estado) {
                                        'PRE-RESERVA' => 'warning text-dark',
                                        'RESERVADO' => 'success text-white',
                                        'NO_DISPONIBLE' => 'secondary text-white',
                                        default => 'light text-dark',
                                    };
                                    $label = match ($r->estado) {
                                        'PRE-RESERVA' => 'PRE-RESERVA',
                                        'RESERVADO' => 'RESERVADO',
                                        'NO_DISPONIBLE' => 'NO DISPONIBLE',
                                        default => $r->estado,
                                    };
                                    $noches = $r->fecha_inicio->diffInDays($r->fecha_fin);
                                @endphp
                                <tr>
                                    <td class="fw-medium">{{ $r->fecha_inicio->format('d/m/Y') }}</td>
                                    <td class="fw-medium">{{ $r->fecha_fin->format('d/m/Y') }}</td>
                                    <td class="text-center">{{ $noches }}</td>
                                    <td><span class="badge bg-{{ $badge }}">{{ $label }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ auth()->check() ? route('reservas.create') : route('login') }}"
                    class="btn btn-agrivall-secondary">
                    Solicitar Reserva
                </a>
            </div>
        </div>
    </section>
</body>

</html>
