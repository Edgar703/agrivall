@extends('layouts.app')

@section('titol', 'Verificar email')

@section('contingut')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card-agrivall">
                <div class="card-body p-4">
                    <h1 class="heading-3 text-green mb-3">Verifica tu email</h1>
                    <p class="text-muted mb-4">
                        Te hemos enviado un enlace de verificacion. Revisa tu correo antes de continuar.
                    </p>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success">
                            Hemos enviado un nuevo enlace de verificacion a tu email.
                        </div>
                    @endif

                    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-between">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-agrivall-primary">
                                Reenviar email
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-agrivall-outline">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection