@once
    <div class="modal fade cart-quantity-modal" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content cart-quantity-modal__content">
                <div class="modal-header cart-quantity-modal__header">
                    <div>
                        <span class="cart-quantity-modal__eyebrow">Añadir al carrito</span>
                        <h5 class="modal-title mb-0" id="addToCartModalLabel" style="color: white">Configura tu compra</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>

                <form action="{{ route('carrito.add') }}" method="POST" class="cart-quantity-modal__form">
                    @csrf
                    <input type="hidden" name="producto_id" class="js-cart-product-id">

                    <div class="modal-body p-4">
                        <div class="cart-quantity-modal__product mb-4">
                            <span class="cart-quantity-modal__product-label">Producto</span>
                            <h6 class="cart-quantity-modal__name js-cart-product-name mb-0">Producto Agrivall</h6>
                            <small class="text-muted js-cart-sale-mode"></small>
                        </div>

                        <div class="mb-3 js-cart-variedad-group d-none">
                            <label for="cartModalVariedad" class="form-label-agrivall">Variedad</label>
                            <select id="cartModalVariedad" name="variedad_id"
                                class="form-control-agrivall js-cart-variedad-select">
                                <option value="">Selecciona una variedad</option>
                            </select>
                        </div>

                        <label for="cartModalQuantity" class="form-label-agrivall d-block text-center mb-2">
                            Cantidad <span class="js-cart-unit-label">ud</span>
                        </label>
                        <p class="text-muted small text-center mb-2 js-cart-stock-help"></p>
                        <div class="cart-quantity-modal__stepper" role="group" aria-label="Seleccionar cantidad">
                            <button type="button" class="cart-quantity-modal__stepper-btn js-cart-quantity-step"
                                data-step="-1" aria-label="Restar cantidad">−</button>
                            <input id="cartModalQuantity" type="number" name="cantidad" value="1" min="0.01" step="1"
                                class="form-control-agrivall cart-quantity-modal__input js-cart-quantity">
                            <button type="button" class="cart-quantity-modal__stepper-btn js-cart-quantity-step"
                                data-step="1" aria-label="Sumar cantidad">+</button>
                        </div>
                    </div>

                    <div class="modal-footer cart-quantity-modal__footer">
                        <button type="submit" class="btn btn-agrivall-primary">Añadir</button>
                        <button type="button" class="btn btn-agrivall-outline" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modalEl = document.getElementById('addToCartModal');
                if (!modalEl) return;

                const productIdInput = modalEl.querySelector('.js-cart-product-id');
                const quantityInput = modalEl.querySelector('.js-cart-quantity');
                const productName = modalEl.querySelector('.js-cart-product-name');
                const saleMode = modalEl.querySelector('.js-cart-sale-mode');
                const unitLabel = modalEl.querySelector('.js-cart-unit-label');
                const stockHelp = modalEl.querySelector('.js-cart-stock-help');
                const variedadGroup = modalEl.querySelector('.js-cart-variedad-group');
                const variedadSelect = modalEl.querySelector('.js-cart-variedad-select');

                const normalizeQuantity = function (value, min, step, integerOnly, max = null) {
                    let parsed = parseFloat(String(value).replace(',', '.'));
                    if (Number.isNaN(parsed) || parsed < min) parsed = min;
                    if (max !== null && parsed > max) parsed = max;
                    const ratio = Math.round(parsed / step);
                    parsed = ratio * step;
                    if (max !== null && parsed > max) parsed = Math.floor(max / step) * step;
                    if (parsed < min) parsed = min;
                    if (integerOnly) parsed = Math.round(parsed);
                    return Number(parsed.toFixed(2));
                };

                const applyStockLimit = function (stock, unidad, min, step) {
                    if (stock !== null && !Number.isNaN(stock)) {
                        quantityInput.max = String(stock);
                        quantityInput.dataset.maxValue = String(stock);
                        stockHelp.textContent = `Stock disponible: ${stock.toFixed(2)} ${unidad}`;
                    } else {
                        quantityInput.removeAttribute('max');
                        quantityInput.dataset.maxValue = '';
                        stockHelp.textContent = '';
                    }

                    const max = quantityInput.dataset.maxValue === '' ? null : parseFloat(quantityInput.dataset.maxValue);
                    const integerOnly = quantityInput.dataset.integerOnly === '1';
                    quantityInput.value = normalizeQuantity(quantityInput.value || min, min, step, integerOnly, max);
                };

                document.querySelectorAll('.js-open-cart-modal').forEach(function (button) {
                    button.addEventListener('click', function () {
                        const tipoVenta = button.dataset.productSaleType || 'unidad';
                        const unidad = button.dataset.productUnit || 'ud';
                        const step = parseFloat(button.dataset.productStep || '1');
                        const min = step;
                        const stock = button.dataset.productStock === '' ? null : parseFloat(button.dataset.productStock || '0');
                        const variedades = JSON.parse(button.dataset.productVariedades || '[]');

                        productIdInput.value = button.dataset.productId || '';
                        productName.textContent = button.dataset.productName || 'Producto Agrivall';
                        saleMode.textContent = tipoVenta === 'peso' ? 'Venta por peso' : 'Venta por unidad';
                        unitLabel.textContent = unidad;
                        quantityInput.min = String(min);
                        quantityInput.step = String(step);
                        quantityInput.value = String(min);
                        quantityInput.dataset.integerOnly = tipoVenta === 'unidad' ? '1' : '0';
                        quantityInput.dataset.stepValue = String(step);
                        quantityInput.dataset.minValue = String(min);
                        applyStockLimit(stock, unidad, min, step);

                        variedadSelect.innerHTML = '<option value="">Selecciona una variedad</option>';
                        if (variedades.length) {
                            variedadGroup.classList.remove('d-none');
                            variedades.forEach(function (variedad) {
                                const option = document.createElement('option');
                                option.value = variedad.id;
                                option.textContent = `${variedad.nombre} · ${parseFloat(variedad.precio).toFixed(2)} €/${unidad}`;
                                if (variedad.stock !== null && variedad.stock !== undefined) {
                                    option.dataset.stock = variedad.stock;
                                    option.textContent += ` · Stock ${parseFloat(variedad.stock).toFixed(2)} ${unidad}`;
                                }
                                if (variedad.agotada) {
                                    option.disabled = true;
                                    option.textContent += ' · Agotada';
                                }
                                variedadSelect.appendChild(option);
                            });
                            variedadSelect.required = true;
                        } else {
                            variedadGroup.classList.add('d-none');
                            variedadSelect.required = false;
                        }

                        bootstrap.Modal.getOrCreateInstance(modalEl).show();
                    });
                });

                variedadSelect.addEventListener('change', function () {
                    const selected = variedadSelect.selectedOptions[0];
                    const step = parseFloat(quantityInput.dataset.stepValue || '1');
                    const min = parseFloat(quantityInput.dataset.minValue || '1');
                    const unidad = unitLabel.textContent || 'ud';
                    const stock = selected?.dataset.stock === undefined ? null : parseFloat(selected.dataset.stock);
                    applyStockLimit(stock, unidad, min, step);
                });

                modalEl.querySelectorAll('.js-cart-quantity-step').forEach(function (button) {
                    button.addEventListener('click', function () {
                        const direction = parseInt(button.dataset.step, 10) || 0;
                        const step = parseFloat(quantityInput.dataset.stepValue || '1');
                        const min = parseFloat(quantityInput.dataset.minValue || '1');
                        const max = quantityInput.dataset.maxValue === '' ? null : parseFloat(quantityInput.dataset.maxValue);
                        const integerOnly = quantityInput.dataset.integerOnly === '1';
                        const current = normalizeQuantity(quantityInput.value, min, step, integerOnly, max);
                        quantityInput.value = normalizeQuantity(current + (direction * step), min, step, integerOnly, max);
                    });
                });

                quantityInput.addEventListener('blur', function () {
                    const step = parseFloat(quantityInput.dataset.stepValue || '1');
                    const min = parseFloat(quantityInput.dataset.minValue || '1');
                    const max = quantityInput.dataset.maxValue === '' ? null : parseFloat(quantityInput.dataset.maxValue);
                    const integerOnly = quantityInput.dataset.integerOnly === '1';
                    quantityInput.value = normalizeQuantity(quantityInput.value, min, step, integerOnly, max);
                });
            });
        </script>
    @endpush
@endonce
