@extends('layouts.app')

@section('titol', 'Editar Reserva #' . $reserva->id)

@section('contingut')
    <div class="animate-fadeInUp">
        <div class="mb-3 mb-md-4">
            <h1 class="heading-2 text-green mb-1 fs-3 fs-md-2">Editar Reserva #{{ $reserva->id }}</h1>
            <p class="text-muted small mb-0">Solo administradores pueden editar reservas</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>¡Atención!</strong> Corrige los siguientes errores:
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card-agrivall">
            <div class="card-body p-3 p-md-4">
                <form action="{{ route('reservas.update', $reserva->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-2 g-md-3">
                        <div class="col-12 col-md-6">
                            <div class="mb-3 mb-md-4">
                                <label for="usuario" class="form-label fw-semibold small">Huésped (no editable)</label>
                                <input type="text" class="form-control-agrivall" value="{{ $reserva->usuario->name }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3 mb-md-4">
                                <label for="email" class="form-label fw-semibold small">Email (no editable)</label>
                                <input type="email" class="form-control-agrivall" value="{{ $reserva->usuario->email }}"
                                    disabled>
                            </div>
                        </div>
                    </div>

                    <hr class="my-2 my-md-3">

                    <div class="mb-3 mb-md-4">
                        <label for="rango_fechas" class="form-label fw-semibold small">
                            Fechas de Reserva <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="rango_fechas" autocomplete="off"
                            class="form-control-agrivall @error('fecha_inicio') is-invalid @enderror @error('fecha_fin') is-invalid @enderror"
                            placeholder="Desde - Hasta" required>
                        <input type="hidden" name="fecha_inicio" id="fecha_inicio"
                            value="{{ old('fecha_inicio', optional($reserva->fecha_inicio)->format('Y-m-d')) }}">
                        <input type="hidden" name="fecha_fin" id="fecha_fin"
                            value="{{ old('fecha_fin', optional($reserva->fecha_fin)->format('Y-m-d')) }}">
                        <div class="form-text small">Minimo 7 dias. Solo desde el mes actual en adelante.</div>
                        <div id="rango_error" class="invalid-feedback d-block"></div>
                        @error('fecha_inicio')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('fecha_fin')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-2 g-md-3">
                        <div class="col-12 col-md-6">
                            <div class="mb-3 mb-md-4">
                                <label for="num_personas" class="form-label fw-semibold small">
                                    Número de Personas <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="num_personas" id="num_personas"
                                    class="form-control-agrivall @error('num_personas') is-invalid @enderror" min="1"
                                    max="10" value="{{ old('num_personas', $reserva->num_personas) }}" required>
                                @error('num_personas')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3 mb-md-4">
                                <label for="estado" class="form-label fw-semibold small">
                                    Estado <span class="text-danger">*</span>
                                </label>
                                <select name="estado" id="estado"
                                    class="form-control-agrivall @error('estado') is-invalid @enderror" required>
                                    <option value="pendiente" @selected(old('estado', $reserva->estado) === 'pendiente')>
                                        Pendiente</option>
                                    <option value="confirmada" @selected(old('estado', $reserva->estado) === 'confirmada')>
                                        Confirmada</option>
                                    <option value="cancelada" @selected(old('estado', $reserva->estado) === 'cancelada')>
                                        Cancelada</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Estimación de Precio -->
                    <div class="card mb-3 mb-md-4" style="border: 2px solid #10b981; border-radius: 12px;">
                        <div class="card-header py-2 px-3"
                            style="background-color: #f0fdf4; border-bottom: 2px solid #10b981;">
                            <h6 class="mb-0 fw-bold text-green small">Estimación de Precio Actualizado</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <p class="text-muted small mb-1">Precio por noche:</p>
                                    <p class="fw-semibold mb-0 small" id="precio_noche">
                                        ${{ number_format($reserva->precio_por_noche ?? config('reservas.precio_por_noche', 50), 2) }}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-muted small mb-1">Número de noches:</p>
                                    <p class="fw-semibold mb-0 small" id="num_noches">{{ $reserva->num_noches }}</p>
                                </div>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <p class="text-muted small mb-1">Personas:</p>
                                    <p class="fw-semibold mb-0 small" id="personas_display">{{ $reserva->num_personas }}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-muted small mb-1">Multiplicador:</p>
                                    <p class="fw-semibold text-green mb-0 small" id="multiplicador_display">
                                        {{ number_format(1 + ($reserva->num_personas - 1) * 0.1, 2) }}x</p>
                                </div>
                            </div>
                            <hr style="border-color: #e5e7eb; margin: 0.75rem 0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold small">Total Estimado:</span>
                                <span class="fw-bold text-green fs-5"
                                    id="precio_total">${{ number_format($reserva->calcularPrecioTotal(), 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 mb-md-4">
                        <label for="comentario" class="form-label fw-semibold small">
                            Comentarios Adicionales
                        </label>
                        <textarea name="comentario" id="comentario" class="form-control-agrivall @error('comentario') is-invalid @enderror"
                            rows="4">{{ old('comentario', $reserva->comentario) }}</textarea>
                        @error('comentario')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info py-2 px-3" role="alert">
                        <strong class="small">Información:</strong>
                        <ul class="mb-0 mt-1 small">
                            <li>Cambios en la semana se reflejarán en la disponibilidad.</li>
                            <li>Si cambias el estado a "cancelada", se liberará la semana.</li>
                            <li>El huésped será notificado de los cambios importantes.</li>
                        </ul>
                    </div>

                    <div class="d-flex flex-column flex-md-row gap-2 mt-3 mt-md-4">
                        <button type="submit" class="btn btn-agrivall-primary">Guardar Cambios</button>
                        <a href="{{ route('reservas.show', $reserva->id) }}"
                            class="btn btn-agrivall-outline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script>
        const PRECIO_POR_NOCHE = {{ $reserva->precio_por_noche ?? config('reservas.precio_por_noche', 50) }};
        const INCREMENTO_POR_PERSONA = {{ config('reservas.incremento_por_persona', 0.1) }};

        function calcularPrecio() {
            const fechaInicio = document.getElementById('fecha_inicio').value;
            const fechaFin = document.getElementById('fecha_fin').value;
            const numPersonas = parseInt(document.getElementById('num_personas').value) || 1;

            // Actualizar personas display
            document.getElementById('personas_display').textContent = numPersonas;

            // Calcular multiplicador
            const multiplicador = 1 + ((numPersonas - 1) * INCREMENTO_POR_PERSONA);
            document.getElementById('multiplicador_display').textContent = multiplicador.toFixed(2) + 'x';

            if (!fechaInicio || !fechaFin) {
                document.getElementById('num_noches').textContent = '-';
                document.getElementById('precio_total').textContent = '-';
                return;
            }

            // Calcular número de noches
            const start = new Date(fechaInicio);
            const end = new Date(fechaFin);
            const diffMs = end - start;
            const numNoches = Math.floor(diffMs / (1000 * 60 * 60 * 24)) || 1;

            document.getElementById('num_noches').textContent = numNoches + (numNoches === 1 ? ' noche' : ' noches');

            // Calcular precio total
            const precioTotal = PRECIO_POR_NOCHE * numNoches * multiplicador;
            document.getElementById('precio_total').textContent = '$' + precioTotal.toFixed(2);
        }

        document.addEventListener('DOMContentLoaded', function() {
            flatpickr.localize(flatpickr.l10ns.es);

            const input = document.getElementById('rango_fechas');
            const startInput = document.getElementById('fecha_inicio');
            const endInput = document.getElementById('fecha_fin');
            const errorBox = document.getElementById('rango_error');
            const disabledRanges = @json($rangosNoDisponibles);
            const minDays = 7;

            const picker = flatpickr(input, {
                mode: 'range',
                dateFormat: 'Y-m-d',
                minDate: 'today',
                disable: disabledRanges,
                defaultDate: startInput.value && endInput.value ? [startInput.value, endInput.value] : null,
                onChange: function(selectedDates, dateStr, instance) {
                    errorBox.textContent = '';

                    if (selectedDates.length === 2) {
                        const start = selectedDates[0];
                        const end = selectedDates[1];
                        const diffDays = Math.floor((end - start) / 86400000);

                        if (diffDays < minDays - 1) {
                            errorBox.textContent = 'Selecciona al menos 7 dias.';
                            startInput.value = '';
                            endInput.value = '';
                            picker.clear();
                            calcularPrecio();
                            return;
                        }

                        startInput.value = instance.formatDate(start, 'Y-m-d');
                        endInput.value = instance.formatDate(end, 'Y-m-d');
                        calcularPrecio();
                    }
                },
            });

            // Listener para cambios en número de personas
            document.getElementById('num_personas').addEventListener('change', calcularPrecio);
            document.getElementById('num_personas').addEventListener('input', calcularPrecio);

            // Calcular precio inicial
            calcularPrecio();
        });
    </script>
@endpush
