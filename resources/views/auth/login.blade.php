@extends('layouts.app')

@section('titol', 'Login')

@section('contingut')
<div class="row justify-content-center animate-fadeInUp">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card-agrivall">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="text-green" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                        </svg>
                    </div>
                    <h1 class="heading-3 text-earth mb-2">Iniciar sesión</h1>
                    <p class="text-muted">Accede a tu cuenta de Agrivall</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label-agrivall">Email</label>
                        <input type="email" name="email" class="form-control-agrivall"
                               value="{{ old('email') }}" required autofocus placeholder="tu@email.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label-agrivall">Contraseña</label>
                        <input type="password" name="password" class="form-control-agrivall" required placeholder="••••••••">
                    </div>

                    <div class="mb-4 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Recuérdame</label>
                    </div>

                    <button class="btn btn-agrivall-primary w-100 mb-3">Entrar</button>

                    <div class="text-center">
                        <a class="text-green hover-underline" href="{{ route('register') }}">
                            ¿No tienes cuenta? Regístrate aquí
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
