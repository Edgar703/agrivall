@extends('layouts.app')

@section('titol', 'Crear producto')

@section('contingut')
<h1 class="h3 mb-3">Crear producto</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    @include('productos.partials.form', ['producto' => null])

    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('productos.catalogo') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
