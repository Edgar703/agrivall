@extends('layouts.app')

@section('titol', 'Editar post')

@section('contingut')

    <div class="d-flex justify-content-start mt-2 gap-3" style="bottom: 20px;">
        <h1 class="h3 mb-3" style="color: #715122;">Editar post</h1>
        <form action="{{ route('posts.destroy', $post) }}" method="POST"
            onsubmit="return confirm('¿Estás seguro de que deseas eliminar este post?');">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn" style="background-color: #715122; color: white;">
                Eliminar
            </button>
        </form>
    </div>

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')

        @include('posts.partials.form', ['post' => $post])

        <div class="d-flex gap-2 mt-3">
            <button class="btn" style="background-color: #715122; color: white;">Actualizar</button>

            <a href="{{ route('posts.show', $post) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>

@endsection