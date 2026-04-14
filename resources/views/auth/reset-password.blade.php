@extends('layouts.app')

@section('titol', 'Restablecer contraseña')

@section('contingut')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="card-agrivall">
                <div class="card-body p-4">
                    <h1 class="heading-3 text-green mb-3">Restablecer contraseña</h1>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva contraseña</label>
                            <input id="password" type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" required
                                autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror" required
                                autocomplete="new-password">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-agrivall-primary w-100">
                            Restablecer contraseña
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection