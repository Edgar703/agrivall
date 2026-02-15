<div class="mb-3" style="display: none;">
    <input type="text" name="id" class="form-control" value="{{ old('id', $post->user_id ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Titulo *</label>
    <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $post->titulo ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Contenido *</label>
    <textarea name="contenido" class="form-control">{{ old('contenido', $post->contenido ?? '') }}</textarea>
</div>

{{-- <div class="mb-3">
    <label class="form-label">Imagen</label>
    @if(isset($post) && $post->imagen)
    <div class="mb-2">
        <img src="{{ asset('storage/' . $post->imagen) }}" alt="Imagen actual" class="img-thumbnail"
            style="max-width: 200px;">
        <p class="text-muted small">Imagen actual</p>
    </div>
    @endif
    <input type="file" name="imagen_file" class="form-control" accept="image/*">
    <small class="text-muted">Formatos permitidos: JPG, PNG, GIF, WEBP (máx. 2MB)</small>
</div> --}}
<div class="mb-3">
    <label class="form-label">Categoria *</label>
    <select name="categoria" class="form-select" id="categoria" style="width: 20%; text-align: left;">
        <option value="Noticia" {{ (old('categoria', $post->categoria ?? '') == 'Noticia') ? 'selected' : '' }}>Noticia
        </option>
        <option value="Evento" {{ (old('categoria', $post->categoria ?? '') == 'Evento') ? 'selected' : '' }}>Evento
        </option>
        <option value="Actualización" {{ (old('categoria', $post->categoria ?? '') == 'Actualización') ? 'selected' : '' }}>Actualización</option>
    </select>
</div>