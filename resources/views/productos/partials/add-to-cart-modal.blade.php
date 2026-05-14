@once
    <div class="modal fade cart-quantity-modal" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content cart-quantity-modal__content">
                <div class="modal-header cart-quantity-modal__header">
                    <div>
                        <span class="cart-quantity-modal__eyebrow">Añadir al carrito</span>
                        <h5 class="modal-title mb-0" id="addToCartModalLabel" style="color: white">Elige
                            la cantidad</h5>
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
                        </div>

                        <label for="cartModalQuantity" class="form-label-agrivall d-block text-center mb-2">
                            Cantidad
                        </label>
                        <div class="cart-quantity-modal__stepper" role="group" aria-label="Seleccionar cantidad">
                            <button type="button" class="cart-quantity-modal__stepper-btn js-cart-quantity-step"
                                data-step="-1" aria-label="Restar cantidad">−</button>
                            <input id="cartModalQuantity" type="number" name="cantidad" value="1" min="1"
                                max="99" class="form-control-agrivall cart-quantity-modal__input js-cart-quantity">
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
            document.addEventListener('DOMContentLoaded', function() {
                const modalEl = document.getElementById('addToCartModal');
                if (!modalEl) return;

                const productIdInput = modalEl.querySelector('.js-cart-product-id');
                const quantityInput = modalEl.querySelector('.js-cart-quantity');
                const productName = modalEl.querySelector('.js-cart-product-name');

                const normalizeQuantity = function(value) {
                    const parsed = parseInt(value, 10);
                    return Math.min(99, Math.max(1, Number.isNaN(parsed) ? 1 : parsed));
                };

                const refreshTotal = function() {
                    const quantity = normalizeQuantity(quantityInput.value);
                    quantityInput.value = quantity;
                };

                document.querySelectorAll('.js-open-cart-modal').forEach(function(button) {
                    button.addEventListener('click', function() {
                        productIdInput.value = button.dataset.productId || '';
                        productName.textContent = button.dataset.productName || 'Producto Agrivall';
                        quantityInput.value = 1;
                        refreshTotal();

                        bootstrap.Modal.getOrCreateInstance(modalEl).show();
                    });
                });

                modalEl.querySelectorAll('.js-cart-quantity-step').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const step = parseInt(button.dataset.step, 10) || 0;
                        quantityInput.value = normalizeQuantity(quantityInput.value) + step;
                        refreshTotal();
                    });
                });

                quantityInput.addEventListener('input', refreshTotal);
                quantityInput.addEventListener('blur', refreshTotal);
            });
        </script>
    @endpush
@endonce
