<div class="mb-3">
    <label class="form-label-agrivall">Nombre *</label>
    <input type="text" name="nombre" class="form-control-agrivall" value="{{ old('nombre', $producto->nombre ?? '') }}"
        placeholder="Ej: Aceite de Oliva Virgen Extra" required>
</div>

<div class="mb-3">
    <label class="form-label-agrivall">Descripcion</label>
    <textarea name="descripcion" class="form-control-agrivall" rows="4"
        placeholder="Descripcion del producto">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label-agrivall">Categoria</label>
        <select name="categoria_id" class="form-control-agrivall">
            <option value="">Sin categoria</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}" {{ (string) old('categoria_id', $producto->categoria_id ?? '') === (string) $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label-agrivall">Precio (EUR) *</label>
        <input type="number" step="0.01" name="precio" class="form-control-agrivall"
            value="{{ old('precio', $producto->precio ?? '') }}" placeholder="0.00" required>
    </div>
</div>

<div class="mb-3">
    <label class="form-label-agrivall">Imagen</label>
    <input type="file" name="imagen_file" class="form-control-agrivall" accept="image/*">
    <small class="text-muted">Formatos permitidos: JPG, PNG, WEBP (max. 2MB)</small>
    @if(isset($producto) && $producto->imagen)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Vista previa" class="rounded"
                style="max-height: 100px;">
        </div>
    @endif
</div>

<div class="row">
    <div class="col-md-6 mb-3 d-flex align-items-end">
        <div class="form-check">
            <input type="hidden" name="activo" value="0">
            <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1" {{ old('activo', $producto->activo ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="activo">
                Producto activo
            </label>
        </div>
    </div>
</div>