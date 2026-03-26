@extends('layouts.app')

@section('titol', 'Editar producto')

@section('contingut')
    <div class="animate-fadeInUp">
        <div class="mb-3 mb-md-4">
            <h1 class="heading-2 text-earth mb-1 fs-3 fs-md-2">Editar Producto</h1>
            <p class="text-muted small mb-0">Actualiza la información del producto</p>
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
                <form action="{{ route('admin.productos.update', $producto) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('admin.productos.partials.form', ['producto' => $producto])

                    <div class="d-flex flex-column flex-md-row gap-2 mt-3 mt-md-4">
                        <button type="submit" class="btn btn-agrivall-primary">Actualizar Producto</button>
                        <a href="{{ route('admin.productos.index') }}" class="btn btn-agrivall-outline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
