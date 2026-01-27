@extends('layouts.app')

@section('titol', 'Posts')

@section('contingut')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 style="color: #76501f">Blog</h1>
    @auth
      <button class="btn" style="background-color: #735122; border: 2px solid #198754; color: white;" data-bs-toggle="modal"
        data-bs-target="#crearPostModal">
        Nuevo post
      </button>
    @endauth

  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
      setTimeout(function () {
        let alert = document.querySelector('.alert-success');
        if (alert) {
          let bsAlert = new bootstrap.Alert(alert);
          bsAlert.close();
        }
      }, 3000);
    </script>
  @endif

  @foreach ($posts as $post)
    <div class="card mb-3" style="border-radius: 15px;border: #198754 2px solid;">
      <div class="row g-0">
        @if($post->imagen)
          <div class="col-md-4">
            <img src="{{ asset('storage/' . $post->imagen) }}" class="img-fluid rounded-start" alt="{{ $post->titulo }}">
          </div>
        @endif
        <div class="col-md-12">
          <div class="card-body">
            <h5 class="card-title">{{ $post->titulo }}</h5>
            <p class="card-text">{{ Str::limit($post->contenido, 150) }}</p>
            <p class="card-text"><small class="text-muted">Publicado el
                {{ $post->created_at->format('d/m/Y') }}</small></p>
            <a href="{{ route('posts.show', $post->id) }}" class="btn" style="color: white; background-color: #76501f; border: 2px solid #198754;">Leer
              más</a>
          </div>
        </div>
      </div>
    </div>
  @endforeach
  <div class="d-flex justify-content-center mt-4">
    {{ $posts->links() }}
  </div>
  <div class="modal fade" id="crearPostModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Crear post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Contenido</label>
            <textarea name="contenido" class="form-control" rows="4"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="categoria" class="form-select">
              <option value="noticia">Noticia</option>
              <option value="blog">Blog</option>
              <option value="evento">Evento</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>

      </form>

    </div>
  </div>
</div>
@endsection
