@extends('layouts.app')

@section('titol', ' Detalle del Post')

@section('contingut')

    <div style="display: flex;">
        <h1 class="h3 m-3"><strong style="color: #715122;">{{ $post->titulo }}</strong></h1>
        @auth
            @if (auth()->user()->id === $post->user_id)
                <div style="display: flex; align-items: center;">
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm d-flex" style="background-color: #715122; color: white;">
                        Editar
                    </a>
                </div>
            @endif
        @endauth
    </div>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container" style="display: grid; grid-template-columns: 1fr; gap: 20px; height: 40vh">
        <div class="col-md-8">
            <div class="card-body">
                <div>
                    <p class="card-text" style="height: fit-content; background-color: white; padding: 5px; border-radius: 5px;">{{ $post->contenido}}</p>
                    <img src="{{ $post->imagen ? asset('storage/' . $post->imagen) : '' }}" alt="">
                    
                </div>
                <p class="card-text"><small class="text-muted">Publicado el {{ $post->created_at->format('d/m/Y') }}</small></p>

                <span class="card-text text-white rounded p-1" style="background-color: #715122;">Categoria: {{ $post->categoria }}</span>
                <span class="card-text text-white rounded p-1" style="background-color: #715122;"> Autor del post: <strong>{{ $post->usuario->name ?? 'Autor desconocido' }}</strong></span>
            </div>
        </div>
    </div>
@endsection