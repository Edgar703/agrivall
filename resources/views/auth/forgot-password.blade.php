@extends('layouts.app')

@section('titol', 'Recuperar contraseña')

@section('contingut')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="card-agrivall">
                <div class="card-body p-4">
                    <h1 class="heading-3 text-green mb-3">Recuperar contraseña</h1>
                    <p class="text-muted mb-4">
                        Indica tu email y te enviaremos un enlace para crear una nueva contraseña.
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-agrivall-primary w-100">
                            Enviar enlace
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection