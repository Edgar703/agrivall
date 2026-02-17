@extends('layouts.app')

@section('titol', 'Agrivall - Contactar')

@section('contingut')
    <section class="py-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <h1 class="h2 fw-bold" style="color: #2d5016;">Contacta con Agrivall</h1>
                <p class="text-muted" style="line-height: 1.8;">
                    Somos una empresa ecologica con certificado ecologico. Trabajamos con productores locales y
                    practicas responsables para ofrecer productos que respetan la tierra y a las personas.
                </p>
                <div class="bg-light border rounded-3 p-3">
                    <div class="d-flex gap-2 mb-3">
                        <span style="font-size: 2rem;">✓</span>
                        <div>
                            <h2 class="h5 mb-1" style="color: #2d5016; font-weight: 600;">Certificado Ecológico CCPAE</h2>
                            <p class="small text-muted mb-2">Número: ES-ECO-2024-001245</p>
                        </div>
                    </div>
                    <p class="mb-2 text-muted" style="line-height: 1.7;">
                        Nuestra producción está certificada por el Consell Català de la Producció Agraria Ecològica (CCPAE).
                        Cumplimos con los más altos estándares de agricultura ecológica, garantizando trazabilidad total y
                        sostenibilidad en cada etapa del proceso.
                    </p>
                    <ul class="small text-muted mb-0" style="line-height: 1.8;">
                        <li>✓ Libre de pesticidas sintéticos</li>
                        <li>✓ Sin fertilizantes químicos</li>
                        <li>✓ Certificación renovada anualmente</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3" style="color: #2d5016;">Escribenos</h2>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error en el formulario:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('contactar.enviar') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                                    name="nombre" value="{{ old('nombre') }}" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electronico</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Telefono (opcional)</label>
                                <input type="tel" class="form-control @error('telefono') is-invalid @enderror" id="telefono"
                                    name="telefono" value="{{ old('telefono') }}">
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="asunto" class="form-label">Asunto</label>
                                <input type="text" class="form-control @error('asunto') is-invalid @enderror" id="asunto"
                                    name="asunto" value="{{ old('asunto') }}" required>
                                @error('asunto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="mensaje" class="form-label">Mensaje</label>
                                <textarea class="form-control @error('mensaje') is-invalid @enderror" id="mensaje"
                                    name="mensaje" rows="5" required>{{ old('mensaje') }}</textarea>
                                @error('mensaje')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-agrivall-primary w-100">Enviar correo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection