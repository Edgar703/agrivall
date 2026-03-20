@extends('layouts.app')

@section('titol', 'Mi Carrito')

@section('contingut')
    <div class="animate-fadeInUp">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="heading-2 text-green mb-1">Mi Carrito</h1>
                <p class="text-muted mb-0">Revisa los productos antes de realizar tu pedido</p>
            </div>
            <a href="{{ route('productos.catalogo') }}" class="btn btn-agrivall-outline btn-sm">← Seguir comprando</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-slideUp" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function() {
                    let alert = document.querySelector('.alert-success');
                    if (alert) {
                        new bootstrap.Alert(alert).close();
                    }
                }, 3000);
            </script>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show animate-slideUp" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (empty($productos))
            <div class="text-center py-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                    class="bi bi-cart-x text-muted mb-3" viewBox="0 0 16 16">
                    <path
                        d="M7.354 5.646a.5.5 0 1 0-.708.708L7.793 7.5 6.646 8.646a.5.5 0 1 0 .708.708L8.5 8.207l1.146 1.147a.5.5 0 0 0 .708-.708L9.207 7.5l1.147-1.146a.5.5 0 0 0-.708-.708L8.5 6.793z" />
                    <path
                        d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                </svg>
                <h3 class="heading-4 text-muted">Tu carrito está vacío</h3>
                <p class="text-muted mb-3">Explora nuestro catálogo y añade productos</p>
                <a href="{{ route('productos.catalogo') }}" class="btn btn-agrivall-primary">Ver Catálogo</a>
            </div>
        @else
            {{-- Vista móvil: Cards --}}
            <div class="d-md-none">
                @foreach ($productos as $item)
                    <div class="card-agrivall mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex gap-3">
                                @php
                                    $img =
                                        $item['producto']->imagen &&
                                        \Illuminate\Support\Facades\Storage::disk('public')->exists(
                                            $item['producto']->imagen,
                                        )
                                            ? asset('storage/' . $item['producto']->imagen)
                                            : asset('assets/img/Agrivall_Logo.png');
                                @endphp
                                <img src="{{ $img }}" alt="{{ $item['producto']->nombre }}" class="rounded"
                                    style="width: 80px; height: 80px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">{{ $item['producto']->nombre }}</h6>
                                    <p class="text-muted small mb-1">{{ number_format($item['producto']->precio, 2) }} € /
                                        ud.</p>
                                    <div class="d-flex align-items-center gap-2">
                                        <form action="{{ route('carrito.update') }}" method="POST"
                                            class="d-flex align-items-center gap-1">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="producto_id" value="{{ $item['producto']->id }}">
                                            <input type="number" name="cantidad" value="{{ $item['cantidad'] }}"
                                                min="1" max="99" class="form-control form-control-sm qty-input"
                                                style="width: 60px;" data-precio="{{ $item['producto']->precio }}">
                                            <button type="submit" class="btn btn-agrivall-outline btn-sm">✓</button>
                                        </form>
                                        <form action="{{ route('carrito.remove', $item['producto']->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm text-danger"
                                                title="Eliminar">✕</button>
                                        </form>
                                    </div>
                                    <p class="fw-bold text-green mt-1 mb-0 subtotal-precio">
                                        {{ number_format($item['subtotal'], 2) }} €</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Vista desktop: Tabla --}}
            <div class="table-agrivall d-none d-md-block">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Precio Ud.</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @php
                                            $img =
                                                $item['producto']->imagen &&
                                                \Illuminate\Support\Facades\Storage::disk('public')->exists(
                                                    $item['producto']->imagen,
                                                )
                                                    ? asset('storage/' . $item['producto']->imagen)
                                                    : asset('assets/img/Agrivall_Logo.png');
                                        @endphp
                                        <img src="{{ $img }}" alt="{{ $item['producto']->nombre }}"
                                            class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                        <div>
                                            <span class="fw-semibold">{{ $item['producto']->nombre }}</span>
                                            <small
                                                class="d-block text-muted">{{ $item['producto']->categoria?->nombre ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ number_format($item['producto']->precio, 2) }} €</td>
                                <td class="text-center">
                                    <form action="{{ route('carrito.update') }}" method="POST"
                                        class="d-flex justify-content-center align-items-center gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="producto_id" value="{{ $item['producto']->id }}">
                                        <input type="number" name="cantidad" value="{{ $item['cantidad'] }}"
                                            min="1" max="99"
                                            class="form-control form-control-sm text-center qty-input" style="width: 65px;"
                                            data-precio="{{ $item['producto']->precio }}">
                                        <button type="submit" class="btn btn-agrivall-outline btn-sm">✓</button>
                                    </form>
                                </td>
                                <td class="text-center fw-bold text-green subtotal-precio">
                                    {{ number_format($item['subtotal'], 2) }} €</td>
                                <td class="text-end">
                                    <form action="{{ route('carrito.remove', $item['producto']->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-agrivall-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Resumen y acciones --}}
            <div class="row justify-content-end mt-4">
                <div class="col-md-5 col-lg-4">
                    <div class="card-agrivall">
                        <div class="card-body p-4">
                            <h5 class="heading-4 text-earth mb-3">Resumen</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Productos</span>
                                <span>{{ count($productos) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold fs-5">Total</span>
                                <span class="fw-bold fs-5 text-green" id="total-carrito">{{ number_format($total, 2) }}
                                    €</span>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="{{ route('pedidos.checkout') }}" class="btn btn-agrivall-primary">
                                    Proceder al pago
                                </a>
                                <form action="{{ route('carrito.clear') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-agrivall-outline btn-sm w-100"
                                        onclick="return confirm('¿Vaciar todo el carrito?')">
                                        Vaciar carrito
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('input', function(e) {
            if (!e.target.classList.contains('qty-input')) return;

            const input = e.target;
            const precio = parseFloat(input.dataset.precio);
            const cantidad = Math.max(1, parseInt(input.value) || 1);
            const subtotal = precio * cantidad;

            // Actualizar subtotal del item (mobile: .card-body, desktop: tr)
            const cardBody = input.closest('.card-body');
            const row = input.closest('tr');
            const contenedor = cardBody || row;
            if (contenedor) {
                const subtotalEl = contenedor.querySelector('.subtotal-precio');
                if (subtotalEl) {
                    subtotalEl.textContent = subtotal.toLocaleString('es-ES', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + ' \u20ac';
                }
            }

            // Recalcular total global
            let total = 0;
            document.querySelectorAll('.qty-input').forEach(function(inp) {
                const p = parseFloat(inp.dataset.precio);
                const q = Math.max(1, parseInt(inp.value) || 1);
                total += p * q;
            });

            const totalEl = document.getElementById('total-carrito');
            if (totalEl) {
                totalEl.textContent = total.toLocaleString('es-ES', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + ' \u20ac';
            }
        });
    </script>
@endpush
