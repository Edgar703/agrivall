@php
    $variedadesOld = old('variedades');
    $variedadesData = is_array($variedadesOld)
        ? $variedadesOld
        : ($producto?->variedades?->map(fn($variedad) => [
            'id' => $variedad->id,
            'nombre' => $variedad->nombre,
            'precio' => $variedad->precio,
            'stock_actual' => $variedad->stock_actual,
            'stock_minimo' => $variedad->stock_minimo,
            'controla_stock' => $variedad->controla_stock,
            'activo' => $variedad->activo,
            'orden' => $variedad->orden,
        ])->values()->all() ?? []);
@endphp

<div class="mb-3">
    <label class="form-label-agrivall">Nombre *</label>
    <input type="text" name="nombre" class="form-control-agrivall" value="{{ old('nombre', $producto->nombre ?? '') }}"
        placeholder="Ej: Aceite de Oliva Virgen Extra" required>
</div>

<div class="mb-3">
    <label class="form-label-agrivall">Descripcion</label>
    <textarea name="descripcion" class="form-control-agrivall" rows="4" placeholder="Descripcion del producto">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
</div>

<div class="row g-2 g-md-3">
    <div class="col-12 col-md-6 mb-3">
        <label class="form-label-agrivall">Categoria</label>
        <select name="categoria_id" class="form-control-agrivall">
            <option value="">Sin categoria</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}"
                    {{ (string) old('categoria_id', $producto->categoria_id ?? '') === (string) $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-12 col-md-6 mb-3">
        <label class="form-label-agrivall">Precio base (EUR) *</label>
        <input type="number" step="0.01" min="0" name="precio" class="form-control-agrivall"
            value="{{ old('precio', $producto->precio ?? '') }}" placeholder="0.00" required>
        <small class="text-muted">Se usa como precio final si no hay variedades.</small>
    </div>
</div>

<div class="row g-2 g-md-3">
    <div class="col-12 col-md-4 mb-3">
        <label class="form-label-agrivall">Tipo de venta *</label>
        <select name="tipo_venta" class="form-control-agrivall js-sale-type">
            @php $tipoVenta = old('tipo_venta', $producto->tipo_venta ?? 'unidad'); @endphp
            <option value="unidad" {{ $tipoVenta === 'unidad' ? 'selected' : '' }}>Por unidad</option>
            <option value="peso" {{ $tipoVenta === 'peso' ? 'selected' : '' }}>Por peso</option>
        </select>
    </div>

    <div class="col-12 col-md-4 mb-3">
        <label class="form-label-agrivall">Unidad *</label>
        @php $unidadMedida = old('unidad_medida', $producto->unidad_medida ?? 'ud'); @endphp
        <select name="unidad_medida" class="form-control-agrivall js-unit-measure">
            <option value="ud" {{ $unidadMedida === 'ud' ? 'selected' : '' }}>ud</option>
            <option value="kg" {{ $unidadMedida === 'kg' ? 'selected' : '' }}>kg</option>
        </select>
    </div>

    <div class="col-12 col-md-4 mb-3">
        <label class="form-label-agrivall">Paso de compra *</label>
        <input type="number" step="0.01" min="0.01" name="step_cantidad" class="form-control-agrivall js-step-cantidad"
            value="{{ old('step_cantidad', $producto->step_cantidad ?? 1) }}" placeholder="1" required>
        <small class="text-muted">Ej: 1 ud, 0.25 kg, 0.50 kg</small>
    </div>
</div>

<div class="row g-2 g-md-3">
    <div class="col-12 col-md-4 mb-3">
        <label class="form-label-agrivall">Stock actual *</label>
        <input type="number" step="0.01" min="0" name="stock_actual" class="form-control-agrivall"
            value="{{ old('stock_actual', $producto->stock_actual ?? 0) }}" placeholder="0.00" required>
        <small class="text-muted">Se usa si el producto no tiene variedades.</small>
    </div>

    <div class="col-12 col-md-4 mb-3">
        <label class="form-label-agrivall">Stock mínimo</label>
        <input type="number" step="0.01" min="0" name="stock_minimo" class="form-control-agrivall"
            value="{{ old('stock_minimo', $producto->stock_minimo ?? 0) }}" placeholder="0.00">
        <small class="text-muted">Aviso visual de últimas unidades.</small>
    </div>

    <div class="col-12 col-md-4 mb-3 d-flex align-items-end">
        <div class="form-check">
            <input type="hidden" name="controla_stock" value="0">
            <input class="form-check-input" type="checkbox" name="controla_stock" id="controla_stock" value="1"
                {{ old('controla_stock', $producto->controla_stock ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="controla_stock">
                Controlar stock
            </label>
        </div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label-agrivall">Imagen</label>
    <input type="file" name="imagen_file" class="form-control-agrivall" accept="image/*">
    <small class="text-muted d-block mt-1">Formatos permitidos: JPG, PNG, WEBP (max. 2MB)</small>
    @if (isset($producto) && $producto->imagen)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Vista previa" class="rounded"
                style="max-height: 100px;">
        </div>
    @endif
</div>

<div class="mb-4 border rounded p-3 bg-light-subtle">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="mb-1 text-green">Variedades</h5>
            <small class="text-muted">Opcional. Si existen, cada una puede tener su propio precio.</small>
        </div>
        <button type="button" class="btn btn-agrivall-outline btn-sm js-add-variedad">+ Añadir variedad</button>
    </div>

    <div class="d-grid gap-3 js-variedades-list">
        @forelse ($variedadesData as $index => $variedad)
            <div class="border rounded p-3 bg-white js-variedad-row">
                <input type="hidden" name="variedades[{{ $index }}][id]" value="{{ $variedad['id'] ?? '' }}">
                <div class="row g-2 align-items-end">
                    <div class="col-12 col-md-3">
                        <label class="form-label-agrivall">Nombre</label>
                        <input type="text" name="variedades[{{ $index }}][nombre]" class="form-control-agrivall"
                            value="{{ $variedad['nombre'] ?? '' }}" placeholder="Ej: Cherry">
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label-agrivall">Precio</label>
                        <input type="number" step="0.01" min="0" name="variedades[{{ $index }}][precio]"
                            class="form-control-agrivall" value="{{ $variedad['precio'] ?? '' }}" placeholder="0.00">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label-agrivall">Stock</label>
                        <input type="number" step="0.01" min="0" name="variedades[{{ $index }}][stock_actual]"
                            class="form-control-agrivall" value="{{ $variedad['stock_actual'] ?? 0 }}" placeholder="0.00">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label-agrivall">Stock mín.</label>
                        <input type="number" step="0.01" min="0" name="variedades[{{ $index }}][stock_minimo]"
                            class="form-control-agrivall" value="{{ $variedad['stock_minimo'] ?? 0 }}" placeholder="0.00">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label-agrivall">Orden</label>
                        <input type="number" min="0" name="variedades[{{ $index }}][orden]" class="form-control-agrivall"
                            value="{{ $variedad['orden'] ?? $index }}">
                    </div>
                    <div class="col-6 col-md-1">
                        <input type="hidden" name="variedades[{{ $index }}][controla_stock]" value="0">
                        <label class="form-label-agrivall d-block">Stock</label>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="variedades[{{ $index }}][controla_stock]"
                                value="1" {{ ($variedad['controla_stock'] ?? true) ? 'checked' : '' }}>
                        </div>
                    </div>
                    <div class="col-6 col-md-1">
                        <input type="hidden" name="variedades[{{ $index }}][activo]" value="0">
                        <label class="form-label-agrivall d-block">Activa</label>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="variedades[{{ $index }}][activo]"
                                value="1" {{ !empty($variedad['activo']) ? 'checked' : '' }}>
                        </div>
                    </div>
                    <div class="col-12 col-md-1 text-md-end">
                        <button type="button" class="btn btn-outline-danger btn-sm js-remove-variedad">✕</button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted mb-0 js-variedades-empty">Este producto no tiene variedades.</p>
        @endforelse
    </div>
</div>

<div class="row g-2 g-md-3">
    <div class="col-12 col-md-6 mb-3 d-flex align-items-end">
        <div class="form-check">
            <input type="hidden" name="activo" value="0">
            <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1"
                {{ old('activo', $producto->activo ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="activo">
                Producto activo
            </label>
        </div>
    </div>
</div>

<template id="variedad-template">
    <div class="border rounded p-3 bg-white js-variedad-row">
        <input type="hidden" data-name="id" value="">
        <div class="row g-2 align-items-end">
            <div class="col-12 col-md-3">
                <label class="form-label-agrivall">Nombre</label>
                <input type="text" class="form-control-agrivall" data-name="nombre" placeholder="Ej: Cherry">
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label-agrivall">Precio</label>
                <input type="number" step="0.01" min="0" class="form-control-agrivall" data-name="precio" placeholder="0.00">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label-agrivall">Stock</label>
                <input type="number" step="0.01" min="0" class="form-control-agrivall" data-name="stock_actual" value="0">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label-agrivall">Stock mín.</label>
                <input type="number" step="0.01" min="0" class="form-control-agrivall" data-name="stock_minimo" value="0">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label-agrivall">Orden</label>
                <input type="number" min="0" class="form-control-agrivall" data-name="orden" value="0">
            </div>
            <div class="col-6 col-md-1">
                <input type="hidden" data-name="controla_stock_hidden" value="0">
                <label class="form-label-agrivall d-block">Stock</label>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" data-name="controla_stock" value="1" checked>
                </div>
            </div>
            <div class="col-6 col-md-1">
                <input type="hidden" data-name="activo_hidden" value="0">
                <label class="form-label-agrivall d-block">Activa</label>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" data-name="activo" value="1" checked>
                </div>
            </div>
            <div class="col-12 col-md-1 text-md-end">
                <button type="button" class="btn btn-outline-danger btn-sm js-remove-variedad">✕</button>
            </div>
        </div>
    </div>
</template>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const saleTypeSelect = document.querySelector('.js-sale-type');
            const unitMeasureSelect = document.querySelector('.js-unit-measure');
            const stepInput = document.querySelector('.js-step-cantidad');
            const addVariedadButton = document.querySelector('.js-add-variedad');
            const variedadesList = document.querySelector('.js-variedades-list');
            const template = document.getElementById('variedad-template');

            if (saleTypeSelect && unitMeasureSelect && stepInput) {
                const syncSaleFields = () => {
                    if (saleTypeSelect.value === 'peso') {
                        unitMeasureSelect.value = 'kg';
                        if (parseFloat(stepInput.value || '0') <= 0 || stepInput.value === '1') {
                            stepInput.value = '0.25';
                        }
                    } else {
                        unitMeasureSelect.value = 'ud';
                        stepInput.value = '1';
                    }
                };

                saleTypeSelect.addEventListener('change', syncSaleFields);
            }

            const updateEmptyState = () => {
                const rows = variedadesList.querySelectorAll('.js-variedad-row');
                let empty = variedadesList.querySelector('.js-variedades-empty');
                if (!rows.length) {
                    if (!empty) {
                        empty = document.createElement('p');
                        empty.className = 'text-muted mb-0 js-variedades-empty';
                        empty.textContent = 'Este producto no tiene variedades.';
                        variedadesList.appendChild(empty);
                    }
                } else if (empty) {
                    empty.remove();
                }
            };

            const reindexRows = () => {
                variedadesList.querySelectorAll('.js-variedad-row').forEach((row, index) => {
                    row.querySelectorAll('[name]').forEach((input) => {
                        const field = input.name.match(/\[(?:id|nombre|precio|stock_actual|stock_minimo|controla_stock|orden|activo)\]$/)?.[0] || '';
                        if (field) {
                            input.name = `variedades[${index}]${field}`;
                        }
                    });
                });
            };

            if (addVariedadButton && template && variedadesList) {
                addVariedadButton.addEventListener('click', function() {
                    const clone = template.content.firstElementChild.cloneNode(true);
                    const index = variedadesList.querySelectorAll('.js-variedad-row').length;

                    clone.querySelectorAll('[data-name]').forEach((input) => {
                        const field = input.dataset.name;
                        if (field === 'activo_hidden' || field === 'controla_stock_hidden') {
                            input.name = `variedades[${index}][${field.replace('_hidden', '')}]`;
                            return;
                        }
                        input.name = `variedades[${index}][${field}]`;
                    });

                    clone.querySelector('[data-name="orden"]').value = index;
                    variedadesList.appendChild(clone);
                    updateEmptyState();
                });

                variedadesList.addEventListener('click', function(event) {
                    if (!event.target.classList.contains('js-remove-variedad')) return;
                    event.target.closest('.js-variedad-row')?.remove();
                    reindexRows();
                    updateEmptyState();
                });

                updateEmptyState();
            }
        });
    </script>
@endpush
