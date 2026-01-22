@extends('layouts.app')

@section('titol', 'Editar post')

@section('contingut')
<h1 class="h3 mb-3">Editar post</h1>

<form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('posts.partials.form', ['post' => $post])

    <div class="d-flex gap-2 mt-3">
        <button class="btn btn-primary">Actualizar</button>

        <a href="{{ route('posts.show', $post) }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<div class="d-flex justify-content-end mt-2" style="bottom: 20px;">
    <form action="{{ route('posts.destroy', $post) }}"
          method="POST"
          onsubmit="return confirm('¿Estás seguro de que deseas eliminar este post?');">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger">
            Eliminar
        </button>
    </form>
</div>


@endsection
