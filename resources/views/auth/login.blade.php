@extends('layouts.app')

@section('titol', 'Login')

@section('contingut')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="h4 mb-3" style="color: #6e4e20;">Iniciar sesión</h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Recuérdame</label>
                    </div>

                    <button class="btn btn-success w-100">Entrar</button>

                    <div class="mt-3 text-center">
                        <a class="text-success" href="{{ route('register') }}">No tengo cuenta, registrarme</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
