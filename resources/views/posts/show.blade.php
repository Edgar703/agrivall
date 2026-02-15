@extends('layouts.app')

@section('titol', ' Detalle del Post')

@section('contingut')
    <div class="container py-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
            <div>
                <p class="text-uppercase text-muted mb-1" style="letter-spacing: 0.08em; font-size: 0.75rem;">
                    Post Agrivall
                </p>
                <h1 class="h2 fw-bold mb-0" style="color: #715122;">{{ $post->titulo }}</h1>
            </div>
            @auth
                @if (auth()->user()->id === $post->user_id)
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm" style="background-color: #715122; color: white;">
                        Editar
                    </a>
                @endif
            @endauth
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-body p-4 p-lg-5">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge" style="background-color: #715122;">{{ $post->categoria }}</span>
                    <span class="badge bg-light text-dark">Publicado {{ $post->created_at->format('d/m/Y') }}</span>
                    <span class="badge bg-light text-dark">Autor: {{ $post->usuario->name ?? 'Autor desconocido' }}</span>
                </div>

                @if($post->imagen)
                    <img src="{{ asset('storage/' . $post->imagen) }}" alt="{{ $post->titulo }}"
                        class="img-fluid rounded-4 mb-4" style="width: 100%; max-height: 420px; object-fit: cover;">
                @endif

                <div class="fs-6" style="line-height: 1.9; color: #2b2b2b;">
                    {{ $post->contenido }}
                </div>
            </div>
        </div>

        <!-- Sección de Comentarios -->
        <div class="mt-5">
            <h3 class="fw-bold mb-4" style="color: #715122;">Comentarios</h3>

            <!-- Mostrar comentarios existentes -->
            @if($post->comentarios->count() > 0)
                <div class="mb-4">
                    @foreach($post->comentarios as $comentario)
                        <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <p class="fw-bold mb-0" style="color: #715122;">
                                            {{ $comentario->usuario->name ?? 'Usuario desconocido' }}
                                        </p>
                                    </div>
                                    @auth
                                        @if(auth()->user()->id === $comentario->user_id || auth()->user()->role === 'admin')
                                            <form action="{{ route('comments.destroy', $comentario) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este comentario?')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                                <p class="mb-0" style="color: #2b2b2b;">{{ $comentario->contenido }}</p>
                                <small class="text-muted">
                                    {{ $comentario->created_at->format('d/m/Y \a \l\a\s H:i') }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted mb-4">No hay comentarios aún. ¡Sé el primero en comentar!</p>
            @endif

            <!-- Formulario para agregar comentario -->
            @auth
                <div class="card border-0 shadow-sm" style="border-radius: 12px; background-color: #f9f7f4;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3" style="color: #715122;">Agregar un comentario</h5>
                        <form action="{{ route('comments.store', $post) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control" name="contenido" rows="4"
                                    placeholder="Escribe tu comentario aquí..."
                                    style="border-radius: 8px; border: 1px solid #d4af8f;" required></textarea>
                                @error('contenido')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-sm fw-bold"
                                style="background-color: #715122; color: white; border-radius: 6px;">
                                Publicar comentario
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info" style="border-radius: 10px; border-left: 4px solid #715122;">
                    <p class="mb-0">
                        <a href="{{ route('login') }}" class="alert-link">Inicia sesión</a> para agregar un comentario.
                    </p>
                </div>
            @endauth
        </div>
    </div>
@endsection