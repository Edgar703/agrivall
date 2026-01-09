<div class="mb-3">
    <label class="form-label">Nombre *</label>
    <input type="text" name="nombre" class="form-control"
           value="{{ old('nombre', $producto->nombre ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Variedad</label>
    <input type="text" name="variedad" class="form-control"
           value="{{ old('variedad', $producto->variedad ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Formato</label>
    <input type="text" name="formato" class="form-control"
           value="{{ old('formato', $producto->formato ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Precio *</label>
    <input type="number" step="0.01" name="precio" class="form-control"
           value="{{ old('precio', $producto->precio ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Imagen</label>
    <input type="file" name="imagen_file" class="form-control" 
           value="{{ old('imagen_file', $producto->imagen ?? '') }}" accept="image/*">
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="disponible" id="disponible"
        {{ old('disponible', $producto->disponible ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="disponible">
        Disponible
    </label>
</div>
