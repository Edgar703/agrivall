@extends('layouts.index')

@section('titol', 'Agrivall - Del campo a tu casa')

@section('body-class', 'page-hero')

@section('contingut')
    <div>
        <!-- Hero Section -->
        <section class="hero-section py-5 mb-5"
            style="background-image: url({{ asset('assets/img/hero.png') }}); background-repeat: no-repeat; background-size: cover; background-position: center;">
            <div class="hero-overlay"></div>
            <div class="container hero-content">
                <div class="row align-items-center justify-content-center p-3 rounded-3 mt-5 hero-panel">
                    <div class="col-lg-8 mb-4 mb-lg-0 text-center">
                        <h1 class="display-4 fw-bold mb-4" style="color: #2d5016;">Bienvenido a Agrivall</h1>
                        <p class="lead mb-4" style="color: black; line-height: 1.8;">
                            Agrivall nace de una idea sencilla pero poderosa: <strong>poner en valor la tierra, las personas
                                y los productos de nuestro entorno.</strong>
                        </p>
                        <p class="mb-4" style="color: black;">
                            Somos un proyecto rural que conecta agricultura local, productos de proximidad y turismo
                            sostenible,
                            apostando por una forma de consumir más cercana, consciente y auténtica.
                        </p>
                        <div class="d-flex gap-3 justify-content-center">
                            <a href="{{ route('productos.catalogo') }}" class="btn btn-agrivall-primary">Explora
                                Productos</a>
                            <a href="{{ route('casa-rural') }}" class="btn btn-agrivall-secondary">Conocer Casa Rural</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quiénes Somos Section -->
        <section class="py-5 mb-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="bg-light rounded-3" style="height: 380px; overflow: hidden;">
                            <img src="{{ asset('assets/img/pic1.png') }}" alt="Quiénes Somos" class="w-100 h-100"
                                style="object-fit: cover;">
                        </div>
                    </div>
                    <div class="col-lg-6 ps-lg-5">
                        <h2 class="h3 fw-bold mb-4" style="color: #2d5016;">Desde el Corazón de la Tierra</h2>
                        <p class="mb-3" style="color: #666; line-height: 1.8;">
                            Desde nuestro territorio trabajamos con <strong>productores locales</strong> para ofrecer
                            alimentos
                            y productos de calidad, elaborados con respeto por la tradición y el medio ambiente.
                        </p>
                        <p class="mb-3" style="color: #666; line-height: 1.8;">
                            Cada producto cuenta una historia: <strong>la de quienes cultivan, elaboran y cuidan lo que
                                llega a
                                tu mesa.</strong>
                        </p>
                        <p class="mb-4" style="color: #666; line-height: 1.8;">
                            Además, Agrivall es también experiencia. A través de nuestra casa rural, invitamos a desconectar
                            del
                            ritmo acelerado y volver a lo esencial: naturaleza, tranquilidad y vida de pueblo.
                        </p>
                        <a href="#casa-rural" class="btn btn-agrivall-primary btn-sm">Descubre Nuestra Casa</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Qué Encontrarás Section -->
        <section class="py-5 mb-5" style="background: transparent;">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-12">
                        <h2 class="h3 fw-bold text-center mb-2" style="color: #2d5016;">¿Qué Encontrarás en Agrivall?</h2>
                        <p class="text-center text-muted" style="font-size: 1.1rem;">Cuatro pilares que sustentan nuestro
                            proyecto</p>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Card 1: Productos Locales -->
                    <div class="col-md-6 col-lg-3">
                        <a href="{{ route('productos.catalogo') }}">
                            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden transition-hover"
                                style="cursor: pointer;">
                                <div class="bg-light rounded-3 m-3" style="height: 200px; overflow: hidden;">
                                    <img src="{{ asset('assets/img/original.jpg') }}" alt="Productos Locales"
                                        class="w-100 h-100" style="object-fit: cover;">
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <span style="font-size: 2rem;">🌱</span>
                                    </div>
                                    <h5 class="card-title fw-bold" style="color: #2d5016;">Productos Locales</h5>
                                    <p class="card-text text-muted" style="font-size: 0.95rem;">
                                        Productos de proximidad, seleccionados con criterio y cariño de productores de
                                        confianza.
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card 2: Compra Online -->
                    <div class="col-md-6 col-lg-3">
                        <a href="{{ route('productos.catalogo') }}">
                            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden transition-hover"
                                style="cursor: pointer;">
                                <div class="bg-light rounded-3 m-3" style="height: 200px; overflow: hidden;">
                                    <img src="{{ asset('assets/img/compra-web.jpg') }}" alt="Productos Locales"
                                        class="w-100 h-100" style="object-fit: cover;">
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <span style="font-size: 2rem;">🛒</span>
                                    </div>
                                    <h5 class="card-title fw-bold" style="color: #2d5016;">Compra Online</h5>
                                    <p class="card-text text-muted" style="font-size: 0.95rem;">
                                        Compra sencilla y segura, apoyando la economía rural y las iniciativas locales.
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card 3: Turismo Rural -->
                    <div class="col-md-6 col-lg-3">
                        <a href="{{ route('casa-rural') }}">
                            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden transition-hover"
                                style="cursor: pointer;">
                                <div class="bg-light rounded-3 m-3" style="height: 200px; overflow: hidden;">
                                    <img src="{{ asset('assets/img/hero.png') }}" alt="Productos Locales"
                                        class="w-100 h-100" style="object-fit: cover;">
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <span style="font-size: 2rem;">🏡</span>
                                    </div>
                                    <h5 class="card-title fw-bold" style="color: #2d5016;">Turismo Rural</h5>
                                    <p class="card-text text-muted" style="font-size: 0.95rem;">
                                        Vive el entorno desde dentro. Desconecta y redescubre el valor de lo simple.
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card 4: Compromiso -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden transition-hover"
                            style="cursor: pointer;">
                            <div class="bg-light rounded-3 m-3" style="height: 200px; overflow: hidden;">
                                <img src="{{ asset('assets/img/compromiso.png') }}" alt="Productos Locales"
                                    class="w-100 h-100" style="object-fit: cover;">
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <span style="font-size: 2rem;">🤝</span>
                                </div>
                                <h5 class="card-title fw-bold" style="color: #2d5016;">Compromiso</h5>
                                <p class="card-text text-muted" style="font-size: 0.95rem;">
                                    Compromiso con el territorio, las personas y la sostenibilidad ambiental.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Experiencia Section -->
        <section class="py-5 mb-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                        <div class="bg-light rounded-3" style="height: 380px; overflow: hidden;">
                            <img src="{{ asset('assets/img/447046025.jpg') }}" alt="Una Experiencia Diferente"
                                class="w-100 h-100" style="object-fit: cover;">
                        </div>
                    </div>
                    <div class="col-lg-6 order-lg-1 pe-lg-5">
                        <h2 class="h3 fw-bold mb-4" style="color: #2d5016;">Una Experiencia Diferente</h2>
                        <p class="mb-3" style="color: #666; line-height: 1.8;">
                            En Agrivall no es solo una tienda ni solo un alojamiento: <strong>es un punto de encuentro entre
                                quienes producen con el corazón y quienes buscan consumir con sentido.</strong>
                        </p>
                        <p class="mb-3" style="color: #666; line-height: 1.8;">
                            Un espacio pensado para descansar, compartir y redescubrir el valor de lo simple. Aquí
                            encontrarás
                            la autenticidad de un entorno genuino, lejos del ruido y cerca de lo que realmente importa.
                        </p>
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-check-circle-fill me-3"
                                    style="color: #7ba428; font-size: 1.3rem; margin-top: 0.2rem;"></i>
                                <div>
                                    <strong style="color: #2d5016;">Naturaleza</strong>
                                    <p class="text-muted small mb-0">Entorno preservado y respetado</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start">
                                <i class="bi bi-check-circle-fill me-3"
                                    style="color: #7ba428; font-size: 1.3rem; margin-top: 0.2rem;"></i>
                                <div>
                                    <strong style="color: #2d5016;">Tranquilidad</strong>
                                    <p class="text-muted small mb-0">Lejos del estrés de la rutina</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start">
                                <i class="bi bi-check-circle-fill me-3"
                                    style="color: #7ba428; font-size: 1.3rem; margin-top: 0.2rem;"></i>
                                <div>
                                    <strong style="color: #2d5016;">Autenticidad</strong>
                                    <p class="text-muted small mb-0">Vida genuina de pueblo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Final Section -->
        <section class="py-5 mb-5" style="background: linear-gradient(135deg, #2d5016 0%, #8b7355 100%); color: white;">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h2 class="h2 fw-bold mb-3">🌿 Del Campo a Tu Casa. De la Tierra a la Experiencia.</h2>
                        <h2 class="h5 fw-bold mb-4" style="opacity: 0.95;">
                            Agrivall es más que un lugar. Es una forma de entender la vida.
                        </h2>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="{{ route('productos.catalogo')}}" class="btn btn-light fw-bold">Descubre Nuestros
                                Productos</a>
                            <a href="{{ route('casa-rural')}}" class="btn btn-outline-light fw-bold">Reserva tu
                                Estancia</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonios / Stats Section -->
        {{-- <section class="py-5 mb-0" style="background: #fafaf9;">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h3 class="h2 fw-bold" style="color: #7ba428;">100+</h3>
                        <p class="text-muted">Productores locales</p>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h3 class="h2 fw-bold" style="color: #7ba428;">Sostenible</h3>
                        <p class="text-muted">Compromiso ambiental</p>
                    </div>
                    <div class="col-md-4">
                        <h3 class="h2 fw-bold" style="color: #7ba428;">Auténtico</h3>
                        <p class="text-muted">Del territorio, para ti</p>
                    </div>
                </div>
            </div>
        </section> --}}

        <style>
            .page-hero {
                --hero-nav-height: 7vh;
            }

            .page-hero .navbar-agrivall {
                position: sticky;
                top: 0;
                z-index: 1030;
                background: linear-gradient(180deg,
                        rgba(45, 106, 79, 0.95) 0%,
                        rgba(45, 106, 79, 0.85) 50%,
                        rgba(45, 106, 79, 0) 100%);
                backdrop-filter: blur(10px);
            }

            .page-hero .hero-section {
                margin-top: calc(-1 * var(--hero-nav-height));
                padding-top: calc(3rem + var(--hero-nav-height));
            }

            @media (max-width: 768px) {
                .page-hero .hero-section {
                    padding-top: calc(3rem + var(--hero-nav-height));
                }
            }
        </style>

@endsection