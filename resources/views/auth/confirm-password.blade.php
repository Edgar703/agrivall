@extends('layouts.app')

@section('titol', 'Confirmar contraseña')

@section('contingut')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="card-agrivall">
                <div class="card-body p-4">
                    <h1 class="heading-3 text-green mb-3">Confirmar contraseña</h1>
                    <p class="text-muted mb-4">
                        Esta zona es segura. Confirma tu contraseña para continuar.
                    </p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="password" class="form-label">Contraseña</label>
                            <input id="password" type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" required
                                autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-agrivall-primary w-100">
                            Confirmar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection