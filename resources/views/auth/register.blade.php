@extends('layouts.app')

@section('titol', 'Registro')

@section('contingut')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="h4 mb-3">Crear cuenta</h1>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Repetir contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button class="btn btn-success w-100">Registrarme</button>

                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}">Ya tengo cuenta, entrar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
