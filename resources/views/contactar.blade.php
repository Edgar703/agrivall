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
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span style="font-size: 1.5rem;">🌿</span>
                        <h2 class="h5 mb-0" style="color: #2d5016;">Certificado ecologico</h2>
                    </div>
                    <p class="mb-0 text-muted" style="line-height: 1.7;">
                        Nuestra produccion cumple con criterios de agricultura ecologica, garantizando trazabilidad y
                        sostenibilidad en todo el proceso.
                    </p>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3" style="color: #2d5016;">Escribenos</h2>
                        <form action="mailto:contacto@agrivall.com" method="post" enctype="text/plain">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electronico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Telefono (opcional)</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="mb-3">
                                <label for="asunto" class="form-label">Asunto</label>
                                <input type="text" class="form-control" id="asunto" name="asunto" required>
                            </div>
                            <div class="mb-4">
                                <label for="mensaje" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-agrivall-primary w-100">Enviar correo</button>
                        </form>
                        <p class="small text-muted mt-3 mb-0">
                            Al enviar se abrira tu cliente de correo con el mensaje preparado.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection