@extends('layouts.app')

@section('titol', 'Casa Rural Agrivall')

@section('contingut')
    {{-- HERO SECTION --}}
    <section class="casa-rural-hero position-relative d-flex align-items-center justify-content-between rounded-3"
        style="background-image: url({{ asset('assets/img/hero.png') }}); background-repeat: no-repeat; background-size: cover; background-position: center;">
        <div class="container-fluid h-100 d-flex align-items-center" style="padding: 0;">
            <div class="row w-100 h-100 align-items-center" style="margin: 0;">
                {{-- Contenido de texto --}}
                <div class="col-lg-6 col-12 d-flex flex-column justify-content-center" style="padding: 3rem 2rem;">
                    <h1 class="display-4 fw-bold text-white mb-3" style="font-family: 'Poppins', sans-serif;">
                        Casa Rural Agrivall
                    </h1>
                    <p class="lead text-white mb-4"
                        style="font-size: 1.25rem; max-width: 500px; text-shadow: 0 2px 8px rgba(255, 255, 255, 1);">
                        Disfruta de una estancia rural única en el corazón de la naturaleza valenciana.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('index') }}" class="btn btn-agrivall-outline btn-lg">
                            Volver al Inicio
                        </a>
                        <a href="{{ auth()->check() ? route('reservas.create') : route('login') }}"
                            class="btn btn-agrivall-secondary btn-lg">
                            Reservar Ahora
                        </a>
                    </div>
                </div>

                {{-- Widget de Reserva --}}
                <div class="col-lg-6 col-12 d-flex justify-content-center align-items-center" style="padding: 2rem;">
                    <div class="card-agrivall" style="width: 100%; max-width: 380px; padding: 2rem; background: white;">
                        <h3 class="h5 fw-bold mb-4" style="color: var(--agrivall-gray-800);">Reservar Casa Rural</h3>

                        <form id="widget-reserva-form">
                            <div class="row g-2 mb-4">
                                <div class="col-12">
                                    <label class="form-label small text-muted">Fechas de Estancia</label>
                                    <div class="input-group">
                                        <input type="text" id="widget-fechas" class="form-control form-control-sm"
                                            placeholder="Selecciona fechas" readonly
                                            data-precio-base="{{ config('reservas.precio_por_noche', 50) }}">
                                        <span class="input-group-text"
                                            style="border-color: #ddd; background: #f9f9f9; font-size: 1rem;">
                                            📅
                                        </span>
                                    </div>
                                    <small id="widget-error-fechas" class="text-danger" style="display: none;"></small>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small text-muted">Número de Personas</label>
                                <select id="widget-personas" class="form-select form-select-sm">
                                    <option value="1">1 persona</option>
                                    <option value="2" selected>2 personas</option>
                                    <option value="3">3 personas</option>
                                    <option value="4">4 personas</option>
                                    <option value="5">5 personas</option>
                                    <option value="6">6 personas</option>
                                    <option value="7">7 personas</option>
                                    <option value="8">8 personas</option>
                                    <option value="9">9 personas</option>
                                    <option value="10">10 personas</option>
                                </select>
                            </div>

                            <div id="widget-precio-container" class="mb-4" style="display: none;">
                                <div class="bg-light p-3 rounded"
                                    style="background: var(--agrivall-cream-light) !important;">
                                    <p class="text-muted small mb-1">Precio estimado</p>
                                    <h4 class="fw-bold mb-1" style="color: var(--agrivall-green-primary);">
                                        <span id="widget-precio-total">--</span> €
                                    </h4>
                                    <small class="text-muted" id="widget-precio-detalle"></small>
                                </div>
                            </div>

                            <button type="button" id="widget-btn-continuar"
                                class="btn btn-agrivall-secondary w-100 btn-lg">
                                Continuar Reserva
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN CARACTERÍSTICAS --}}
    <section class="py-5" style="background: var(--agrivall-cream-light);">
        <div class="container">
            <h2 class="h2 fw-bold mb-3" style="color: var(--agrivall-gray-800);">Desconecta en plena Naturaleza</h2>
            <p class="lead text-muted mb-5" style="max-width: 600px;">
                Casa Rural Agrivall es un remanso de paz y quietud. Aquí podrías relajarte y disfrutarás del entorno natural
                valenciano, rodeado de montañas, campos y el canto de los pájaros.
            </p>

            <div class="row g-4">
                {{-- Galería de imágenes (oculta en móvil con CSS) --}}
                <div class="col-lg-5 d-none d-lg-block">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; grid-template-rows: auto auto;">
                        <img src="{{ asset('assets/img/casa/cama.jpg') }}" class="rounded"
                            style="grid-column: 1 / 2; grid-row: 1 / 3; width: 100%; height: 100%; object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"
                            alt="Sala de estar">
                        <img src="{{ asset('assets/img/casa/rio.jpg') }}" class="rounded"
                            style="grid-column: 2 / 3; grid-row: 1 / 2; width: 100%; height: 100%; object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"
                            alt="Atardecer">
                        <img src="{{ asset('assets/img/casa/cama2.jpg') }}" class="rounded"
                            style="grid-column: 2 / 3; grid-row: 2 / 3; width: 100%; height: 100%; object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"
                            alt="Habitación">
                    </div>
                </div>

                {{-- Características --}}
                <div class="col-lg-7 col-12">
                    <div class="row g-3 g-lg-4">
                        {{-- Característica 1 --}}
                        <div class="col-md-6 col-12">
                            <div class="d-flex gap-3">
                                <div style="font-size: 2rem; min-width: 50px; flex-shrink: 0;">🌿</div>
                                <div>
                                    <h4 class="fw-bold mb-2" style="color: var(--agrivall-green-primary);">Entorno Natural
                                    </h4>
                                    <p class="text-muted small">Rodeado de campos, huertos, y montañas con vistas naturales.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Característica 2 --}}
                        <div class="col-md-6 col-12">
                            <div class="d-flex gap-3">
                                <div style="font-size: 2rem; min-width: 50px; flex-shrink: 0;">🏡</div>
                                <div>
                                    <h4 class="fw-bold mb-2" style="color: var(--agrivall-green-primary);">Confort y
                                        Calidez
                                    </h4>
                                    <p class="text-muted small">3 habitaciones acogedoras y chimenea para noches cálidas.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Característica 3 --}}
                        <div class="col-md-6 col-12">
                            <div class="d-flex gap-3">
                                <div style="font-size: 2rem; min-width: 50px; flex-shrink: 0;">☕</div>
                                <div>
                                    <h4 class="fw-bold mb-2" style="color: var(--agrivall-green-primary);">Desayuno Casero
                                    </h4>
                                    <p class="text-muted small">Con productos locales frescos casero matutino.</p>
                                </div>
                            </div>
                        </div>

                        {{-- Característica 4 --}}
                        <div class="col-md-6 col-12">
                            <div class="d-flex gap-3">
                                <div style="font-size: 2rem; min-width: 50px; flex-shrink: 0;">🥾</div>
                                <div>
                                    <h4 class="fw-bold mb-2" style="color: var(--agrivall-green-primary);">Actividades
                                    </h4>
                                    <p class="text-muted small">Senderismo rurales y experiencias únicas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN DE PRECIO Y CTA --}}
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-4 flex-column-reverse flex-lg-row">
                <div class="col-lg-6 col-12">
                    <img src="{{ asset('assets/img/casa/fachada.jpg') }}" class="rounded img-fluid"
                        style="width: 100%; height: auto; box-shadow: 0 8px 24px rgba(0,0,0,0.15);"
                        alt="Vista panorámica">
                </div>
                <div class="col-lg-6 col-12">
                    <h3 class="h3 fw-bold mb-4" style="color: var(--agrivall-gray-800);">
                        Una experiencia inolvidable
                    </h3>
                    <p class="mb-4 text-muted" style="line-height: 1.8;">
                        Nuestra casa rural es el lugar perfecto para desconectar del estrés de la ciudad y reconectar con la
                        naturaleza. Disfruta de un ambiente tranquilo y acogedor con todas las comodidades necesarias para
                        una estancia memorable.
                    </p>

                    <div class="bg-light p-4 rounded mb-4" style="background: var(--agrivall-cream-light) !important;">
                        <p class="text-muted small mb-2">Precio estimado por semana para 4 personas</p>
                        <h2 class="display-6 fw-bold mb-0" style="color: var(--agrivall-green-primary);">
                            585 €
                        </h2>
                    </div>

                    <button class="btn btn-agrivall-secondary btn-lg w-100"
                        onclick="document.querySelector('#booking-widget').scrollIntoView({ behavior: 'smooth' })">
                        Reservar Ahora
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- TARJETA DE GALERÍA COMPLETA (opcional) --}}
    <section id="booking-widget" class="py-5" style="background: var(--agrivall-cream-light);">
        <div class="container">
            <h2 class="h3 fw-bold mb-4" style="color: var(--agrivall-gray-800);">Galería de la Casa</h2>
            <div class="row g-2 g-md-3">
                @php
                    $imagenes = [
                        'assets/img/casa/cama.jpg',
                        'assets/img/casa/rio.jpg',
                        'assets/img/casa/cama3.jpg',
                        'assets/img/casa/cama2.jpg',
                        'assets/img/casa/fachada.jpg',
                        'assets/img/casa/cocina.jpg',
                    ];
                @endphp

                @foreach ($imagenes as $imagen)
                    <div class="col-6 col-md-4">
                        <div class="overflow-hidden rounded"
                            style="height: 200px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            <img src="{{ $imagen }}" alt="Galería" class="w-100 h-100"
                                style="object-fit: cover; transition: transform 0.3s ease; cursor: pointer;"
                                onmouseover="this.style.transform='scale(1.05)'"
                                onmouseout="this.style.transform='scale(1)'">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        /* ESTILOS PERSONALIZADOS PARA CASA RURAL */
        .casa-rural-hero {
            position: relative;
            min-height: 500px;
        }

        .btn-agrivall-outline {
            border: 2px solid white;
            color: white;
            background: transparent;
        }

        .btn-agrivall-outline:hover {
            background: white;
            color: var(--agrivall-green-primary);
            border-color: white;
        }

        .form-control,
        .form-select {
            border-color: #ddd;
            border-radius: var(--radius-md);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--agrivall-green-primary);
            box-shadow: 0 0 0 0.2rem rgba(45, 106, 79, 0.25);
        }

        .form-control-sm,
        .form-select-sm {
            border-color: #ddd;
        }

        .input-group-text {
            background-color: #f9f9f9;
            border-color: #ddd;
        }

        /* ESTILOS TABLET (991px y menor) */
        @media (max-width: 991px) {
            .casa-rural-hero {
                min-height: auto;
                padding: 2rem 0;
            }

            .casa-rural-hero h1 {
                font-size: 2rem;
            }

            .casa-rural-hero .lead {
                font-size: 1rem;
            }

            .casa-rural-hero .d-flex.gap-3 {
                flex-direction: column;
            }

            .casa-rural-hero .btn {
                width: 100%;
            }

            .card-agrivall {
                margin-top: 1.5rem;
            }

            h2.h2 {
                font-size: 1.5rem;
            }

            h3.h3 {
                font-size: 1.25rem;
            }

            .py-5 {
                padding: 2rem 0;
            }

            .row.flex-column-reverse {
                flex-direction: column-reverse;
            }
        }

        /* ESTILOS MÓVIL PEQUEÑO (575px y menor) */
        @media (max-width: 575px) {
            .casa-rural-hero {
                min-height: auto;
                padding: 1.5rem 0;
            }

            .casa-rural-hero h1 {
                font-size: 1.5rem;
            }

            .casa-rural-hero .lead {
                font-size: 0.9rem;
                max-width: 100%;
            }

            .casa-rural-hero .col-lg-6,
            .casa-rural-hero .col-12 {
                padding: 1rem !important;
            }

            .casa-rural-hero .btn-lg {
                padding: 0.6rem 1rem;
                font-size: 0.95rem;
            }

            .card-agrivall {
                padding: 1.5rem !important;
                margin-top: 1rem;
            }

            .card-agrivall h3 {
                font-size: 0.95rem;
            }

            .form-label {
                font-size: 0.75rem;
            }

            .form-control-sm,
            .form-select-sm {
                font-size: 0.85rem;
            }

            h2.h2 {
                font-size: 1.25rem;
            }

            h3.h3 {
                font-size: 1rem;
            }

            h4.fw-bold {
                font-size: 0.95rem;
            }

            .py-5 {
                padding: 1.5rem 0;
            }

            .row.g-3 {
                gap: 0.75rem;
            }

            .d-flex.gap-3 {
                gap: 0.75rem;
            }

            .overflow-hidden {
                height: 150px !important;
            }

            .display-6 {
                font-size: 1.5rem;
            }

            p.lead {
                font-size: 0.9rem;
            }

            p.text-muted {
                font-size: 0.85rem;
            }

            p.small {
                font-size: 0.75rem;
            }

            .btn-sm {
                padding: 0.4rem 0.8rem;
                font-size: 0.75rem;
            }

            .row.flex-column-reverse {
                flex-direction: column;
            }

            .d-flex.flex-wrap {
                flex-wrap: wrap;
            }
        }
    </style>

    {{-- CSS de Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/light.css">

    {{-- JavaScript de Flatpickr --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const widgetFechas = document.getElementById('widget-fechas');
            const widgetPersonas = document.getElementById('widget-personas');
            const widgetPrecioContainer = document.getElementById('widget-precio-container');
            const widgetPrecioTotal = document.getElementById('widget-precio-total');
            const widgetPrecioDetalle = document.getElementById('widget-precio-detalle');
            const widgetErrorFechas = document.getElementById('widget-error-fechas');
            const widgetBtnContinuar = document.getElementById('widget-btn-continuar');

            const precioBase = parseFloat(widgetFechas.dataset.precioBase) || 50;

            let fechaInicio = null;
            let fechaFin = null;
            let fechasBloqueadas = [];

            // Cargar fechas bloqueadas desde el servidor
            fetch('/api/reservas/fechas-bloqueadas')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fechasBloqueadas = data.fechas_bloqueadas || [];
                        inicializarFlatpickr();
                    }
                })
                .catch(error => {
                    console.error('Error cargando fechas bloqueadas:', error);
                    inicializarFlatpickr();
                });

            function inicializarFlatpickr() {
                flatpickr(widgetFechas, {
                    mode: 'range',
                    minDate: 'today',
                    dateFormat: 'Y-m-d',
                    locale: 'es',
                    disable: fechasBloqueadas,
                    onChange: function(selectedDates, dateStr, instance) {
                        widgetErrorFechas.style.display = 'none';

                        if (selectedDates.length === 2) {
                            fechaInicio = selectedDates[0];
                            fechaFin = selectedDates[1];

                            // Validar mínimo 7 días
                            const diffDays = Math.floor((fechaFin - fechaInicio) / (1000 * 60 * 60 *
                                24));

                            if (diffDays < 7) {
                                widgetErrorFechas.textContent = 'La estancia mínima es de 7 días';
                                widgetErrorFechas.style.display = 'block';
                                widgetPrecioContainer.style.display = 'none';
                                return;
                            }

                            calcularPrecio();
                        } else {
                            widgetPrecioContainer.style.display = 'none';
                        }
                    }
                });
            }

            // Event listener para cambio de personas
            widgetPersonas.addEventListener('change', function() {
                if (fechaInicio && fechaFin) {
                    calcularPrecio();
                }
            });

            // Función para calcular precio
            function calcularPrecio() {
                const numPersonas = parseInt(widgetPersonas.value);

                if (!fechaInicio || !fechaFin) {
                    return;
                }

                const fechaInicioStr = fechaInicio.toISOString().split('T')[0];
                const fechaFinStr = fechaFin.toISOString().split('T')[0];

                // Mostrar loader
                widgetPrecioTotal.textContent = '...';
                widgetPrecioContainer.style.display = 'block';

                // Llamar al API
                fetch('/api/reservas/calcular-precio', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            fecha_inicio: fechaInicioStr,
                            fecha_fin: fechaFinStr,
                            num_personas: numPersonas
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            widgetPrecioTotal.textContent = data.precio_total.toFixed(0);
                            widgetPrecioDetalle.textContent =
                                `${data.num_noches} noches × ${data.precio_base_noche}€ × ${data.multiplicador}x`;
                        } else {
                            widgetErrorFechas.textContent = data.error || 'Error al calcular el precio';
                            widgetErrorFechas.style.display = 'block';
                            widgetPrecioContainer.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error calculando precio:', error);
                        widgetPrecioTotal.textContent = '--';
                        widgetPrecioDetalle.textContent = 'Error al calcular';
                    });
            }

            // Botón continuar reserva
            widgetBtnContinuar.addEventListener('click', function() {
                @if (auth()->check())
                    if (!fechaInicio || !fechaFin) {
                        widgetErrorFechas.textContent = 'Por favor selecciona las fechas de tu estancia';
                        widgetErrorFechas.style.display = 'block';
                        return;
                    }

                    const fechaInicioStr = fechaInicio.toISOString().split('T')[0];
                    const fechaFinStr = fechaFin.toISOString().split('T')[0];
                    const numPersonas = widgetPersonas.value;

                    // Construir URL con query params
                    const url =
                        `{{ route('reservas.create') }}?fecha_inicio=${fechaInicioStr}&fecha_fin=${fechaFinStr}&num_personas=${numPersonas}`;
                    window.location.href = url;
                @else
                    window.location.href = '{{ route('login') }}';
                @endif
            });
        });
    </script>
@endsection
