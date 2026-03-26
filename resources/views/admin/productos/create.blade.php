@extends('layouts.app')

@section('titol', 'Crear producto')

@section('contingut')
    <div class="animate-fadeInUp">
        <div class="mb-3 mb-md-4">
            <h1 class="heading-2 text-green mb-1 fs-3 fs-md-2">Crear Nuevo Producto</h1>
            <p class="text-muted small mb-0">Añade un producto al catálogo</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>¡Atención!</strong> Corrige los siguientes errores:
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card-agrivall">
            <div class="card-body p-3 p-md-4">
                <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="return_to" value="{{ old('return_to', $returnTo) }}">

                    @include('admin.productos.partials.form', ['producto' => null])

                    <div class="d-flex flex-column flex-md-row gap-2 mt-3 mt-md-4">
                        <button type="submit" class="btn btn-agrivall-primary">Guardar Producto</button>
                        <a href="{{ $returnTo }}" class="btn btn-agrivall-outline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
