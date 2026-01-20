<div class="mb-3">
    <label class="form-label">Titulo *</label>
    <input type="text" name="titulo" class="form-control"
           value="{{ old('titulo', $post->titulo ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Contenido</label>
    <textarea name="contenido" class="form-control">{{ old('contenido', $post->contenido ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Imagen</label>
    <input type="file" name="imagen_file" class="form-control" 
           value="{{ old('imagen_file', $post->imagen ?? '') }}" accept="image/*">
</div>

<div class="mb-3">
    <label class="form-label">Categoria *</label>
    <input type="text" name="categoria" class="form-control"
           value="{{ old('categoria', $post->categoria ?? '') }}">
</div>
