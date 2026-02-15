@extends('layouts.app')

@section('titol', 'Blog')

@section('contingut')
  <div class="posts-layout">
    <div class="row g-4">
      <aside class="col-lg-3">
        <div class="posts-sidebar">
          <div class="card border-0">
            <div class="card-body p-4">
              <h5 class="heading-4 text-earth mb-3">Filtrar posts</h5>
              <form action="{{ route('posts.index') }}" method="GET">
                <div class="mb-3">
                  <label class="form-label-agrivall">Buscar</label>
                  <input type="text" name="q" class="form-control-agrivall" value="{{ request('q') }}"
                    placeholder="Título, contenido o autor">
                </div>

                <div class="mb-3">
                  <label class="form-label-agrivall">Categoría</label>
                  <select name="categoria" class="form-control-agrivall">
                    <option value="">Todas</option>
                    <option value="noticia" {{ request('categoria') == 'noticia' ? 'selected' : '' }}>📰 Noticia</option>
                    <option value="blog" {{ request('categoria') == 'blog' ? 'selected' : '' }}>✍️ Blog</option>
                    <option value="evento" {{ request('categoria') == 'evento' ? 'selected' : '' }}>📅 Evento</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label-agrivall">Fecha (rango)</label>
                  <div class="d-grid gap-2">
                    <input type="date" name="from" class="form-control-agrivall" value="{{ request('from') }}">
                    <input type="date" name="to" class="form-control-agrivall" value="{{ request('to') }}">
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label-agrivall">Fecha rápida</label>
                  <select name="preset" class="form-control-agrivall">
                    <option value="">Sin filtro</option>
                    <option value="7" {{ request('preset') == '7' ? 'selected' : '' }}>Últimos 7 días</option>
                    <option value="30" {{ request('preset') == '30' ? 'selected' : '' }}>Últimos 30 días</option>
                    <option value="90" {{ request('preset') == '90' ? 'selected' : '' }}>Últimos 90 días</option>
                  </select>
                  <small class="text-muted">Si eliges rango, tiene prioridad.</small>
                </div>

                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-agrivall-primary btn-sm">Aplicar filtros</button>
                  <a href="{{ route('posts.index') }}" class="btn btn-agrivall-outline btn-sm">Limpiar</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </aside>

      <div class="col-lg-9">
        <div class="animate-fadeInUp">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
              <h1 class="heading-2 text-earth mb-1">Blog Agrivall</h1>
              <p class="text-muted mb-0">Noticias, artículos y novedades</p>
            </div>
            @auth
              <button class="btn btn-agrivall-secondary" data-bs-toggle="modal" data-bs-target="#crearPostModal">
                ✏️ Nuevo Post
              </button>
            @endauth
          </div>

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-slideUp" role="alert">
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

          @forelse ($posts as $post)
            <div class="card-agrivall mb-4 animate-fadeInUp">
              <div class="row g-0">
                @if($post->imagen)
                  <div class="col-md-4">
                    <div class="img-zoom" style="height: 100%; min-height: 250px;">
                      <img src="{{ asset('storage/' . $post->imagen) }}" class="img-fluid h-100 w-100"
                        alt="{{ $post->titulo }}" style="object-fit: cover;">
                    </div>
                  </div>
                @endif
                <div class="{{ $post->imagen ? 'col-md-8' : 'col-md-12' }}">
                  <div class="card-body p-4">
                    <h5 class="heading-4 text-earth mb-3">{{ $post->titulo }}</h5>
                    <p class="card-text mb-3">{{ Str::limit($post->contenido, 150) }}</p>

                    <div class="d-flex justify-content-between align-items-center">
                      <div class="text-muted small">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                          class="bi bi-calendar3 me-1" viewBox="0 0 16 16">
                          <path
                            d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z" />
                          <path
                            d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                        </svg>
                        {{ $post->created_at->format('d/m/Y') }}
                        @if($post->categoria)
                          <span class="badge badge-earth ms-2">{{ ucfirst($post->categoria) }}</span>
                        @endif
                      </div>
                      <a href="{{ route('posts.show', $post->id) }}" class="btn btn-agrivall-primary btn-sm">
                        Leer más →
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="text-center py-5">
              <div class="mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                  class="bi bi-journal-text text-muted opacity-50" viewBox="0 0 16 16">
                  <path
                    d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                  <path
                    d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                  <path
                    d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                </svg>
              </div>
              <h3 class="heading-4 text-muted">No hay posts publicados</h3>
              @auth
                <p class="text-muted mb-3">Crea el primer post del blog</p>
                <button class="btn btn-agrivall-primary" data-bs-toggle="modal" data-bs-target="#crearPostModal">
                  + Crear Post
                </button>
              @endauth
            </div>
          @endforelse

          <div class="d-flex justify-content-center mt-4">
            {{ $posts->appends(request()->query())->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal Crear Post --}}
  <div class="modal fade" id="crearPostModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="border-radius: var(--radius-lg); overflow: hidden;">

        <div class="modal-header" style="background: var(--gradient-earth); color: white;">
          <h5 class="modal-title fw-semibold">✏️ Crear Nuevo Post</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <form action="{{ route('posts.store') }}" method="POST">
          @csrf

          <div class="modal-body p-4">
            <div class="mb-3">
              <label class="form-label-agrivall">Título</label>
              <input type="text" name="titulo" class="form-control-agrivall" required
                placeholder="Escribe un título atractivo...">
            </div>

            <div class="mb-3">
              <label class="form-label-agrivall">Contenido</label>
              <textarea name="contenido" class="form-control-agrivall" rows="6" required
                placeholder="Escribe el contenido del post..."></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label-agrivall">Categoría</label>
              <select name="categoria" class="form-control-agrivall" required>
                <option value="">Selecciona una categoría...</option>
                <option value="noticia">📰 Noticia</option>
                <option value="blog">✍️ Blog</option>
                <option value="evento">📅 Evento</option>
              </select>
            </div>

          </div>

          <div class="modal-footer bg-light">
            <button type="button" class="btn btn-agrivall-outline" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-agrivall-primary">Publicar Post</button>
          </div>

        </form>

      </div>
    </div>
  </div>
@endsection