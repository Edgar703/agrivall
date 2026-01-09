@extends('layouts.app')

@section('titol', 'Editar producto')

@section('contingut')
<h1 class="h3 mb-3">Editar producto</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('productos.partials.form', ['producto' => $producto])

    <button class="btn btn-primary">Actualizar</button>
    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
