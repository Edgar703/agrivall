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
    </div>
@endsection