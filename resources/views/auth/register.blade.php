@extends('layouts.app')

@section('titol', 'Registro')

@section('contingut')
<div class="row justify-content-center animate-fadeInUp">
    <div class="col-md-8 col-lg-6">
        <div class="card-agrivall">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="text-earth" viewBox="0 0 16 16">
                            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                        </svg>
                    </div>
                    <h1 class="heading-3 text-earth mb-2">Crear cuenta</h1>
                    <p class="text-muted">Unéte a la comunidad de Agrivall</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label-agrivall">Nombre</label>
                        <input type="text" name="name" class="form-control-agrivall"
                               value="{{ old('name') }}" required autofocus placeholder="Tu nombre completo">
                    </div>

                    <div class="mb-3">
                        <label class="form-label-agrivall">Email</label>
                        <input type="email" name="email" class="form-control-agrivall"
                               value="{{ old('email') }}" required placeholder="tu@email.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label-agrivall">Contraseña</label>
                        <input type="password" name="password" class="form-control-agrivall" required placeholder="Mínimo 8 caracteres">
                    </div>

                    <div class="mb-4">
                        <label class="form-label-agrivall">Repetir contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control-agrivall" required placeholder="Confirma tu contraseña">
                    </div>

                    <button class="btn btn-agrivall-primary w-100 mb-3">Registrarme</button>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-green hover-underline">
                            ¿Ya tienes cuenta? Inicia sesión
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
