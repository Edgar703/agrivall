<div class="mb-3">
    <label class="form-label-agrivall">Nombre *</label>
    <input type="text" name="nombre" class="form-control-agrivall" value="{{ old('nombre', $producto->nombre ?? '') }}"
        placeholder="Ej: Aceite de Oliva Virgen Extra" required>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label-agrivall">Variedad</label>
        <input type="text" name="variedad" class="form-control-agrivall"
            value="{{ old('variedad', $producto->variedad ?? '') }}" placeholder="Ej: Picual">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label-agrivall">Formato</label>
        <input type="text" name="formato" class="form-control-agrivall"
            value="{{ old('formato', $producto->formato ?? '') }}" placeholder="Ej: 500ml">
    </div>
</div>

<div class="mb-3">
    <label class="form-label-agrivall">Precio (€) *</label>
    <input type="number" step="0.01" name="precio" class="form-control-agrivall"
        value="{{ old('precio', $producto->precio ?? '') }}" placeholder="0.00" required>
</div>

<div class="mb-3">
    <label class="form-label-agrivall">Imagen</label>
    <input type="file" name="imagen_file" class="form-control-agrivall" accept="image/*">
    <small class="text-muted">Formatos permitidos: JPG, PNG, WEBP (máx. 2MB)</small>
    @if(isset($producto) && $producto->imagen)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Vista previa" class="rounded"
                style="max-height: 100px;">
        </div>
    @endif
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="disponible" id="disponible" {{ old('disponible', $producto->disponible ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="disponible">
        Producto disponible para la venta
    </label>
</div>