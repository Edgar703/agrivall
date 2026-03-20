@extends('layouts.app')

@section('titol', 'Checkout')

@section('contingut')
    <div class="animate-fadeInUp">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('carrito.index') }}" class="text-green">Carrito</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>

        <h1 class="heading-2 text-green mb-4">Finalizar Pedido</h1>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('pedidos.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                {{-- Formulario de datos --}}
                <div class="col-lg-7">
                    <div class="card-agrivall">
                        <div class="card-body p-4">
                            <h5 class="heading-4 text-earth mb-3">Datos de envío</h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-agrivall">Nombre completo</label>
                                    <input type="text" name="nombre_cliente" class="form-control-agrivall"
                                        value="{{ old('nombre_cliente', $user->name) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-agrivall">Email</label>
                                    <input type="email" name="email_cliente" class="form-control-agrivall"
                                        value="{{ old('email_cliente', $user->email) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-agrivall">Teléfono</label>
                                    <input type="text" name="tlf_cliente" class="form-control-agrivall"
                                        value="{{ old('tlf_cliente') }}" placeholder="Ej: 612345678" required
                                        maxlength="15">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-agrivall">Método de pago</label>
                                    <select name="metodo_pago" class="form-control-agrivall" required>
                                        <option value="">Seleccionar...</option>
                                        @foreach (['Bizzum', 'Transferencia'] as $metodo)
                                            <option value="{{ $metodo }}"
                                                {{ old('metodo_pago') === $metodo ? 'selected' : '' }}>
                                                {{ $metodo }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label-agrivall">Dirección de envío</label>
                                    <textarea name="direccion_envio" class="form-control-agrivall" rows="2" required
                                        placeholder="Calle, número, ciudad, código postal...">{{ old('direccion_envio') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Resumen del pedido --}}
                <div class="col-lg-5">
                    <div class="card-agrivall">
                        <div class="card-body p-4">
                            <h5 class="heading-4 text-earth mb-3">Resumen del pedido</h5>

                            @foreach ($items as $item)
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                    <div>
                                        <span class="fw-semibold">{{ $item['producto']->nombre }}</span>
                                        <small class="d-block text-muted">{{ $item['cantidad'] }} ×
                                            {{ number_format($item['producto']->precio, 2) }} €</small>
                                    </div>
                                    <span class="fw-bold">{{ number_format($item['subtotal'], 2) }} €</span>
                                </div>
                            @endforeach

                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold fs-5">Total</span>
                                <span class="fw-bold fs-5 text-green">{{ number_format($total, 2) }} €</span>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-agrivall-primary btn-lg">
                                    Confirmar Pedido
                                </button>
                            </div>
                            <div class="text-center mt-2">
                                <a href="{{ route('carrito.index') }}" class="text-muted small">← Volver al carrito</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
