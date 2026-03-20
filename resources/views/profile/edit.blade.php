@extends('layouts.app')

@section('titol', 'Mi Perfil')

@section('contingut')
    <div class="animate-fadeInUp">
        <div class="mb-4">
            <h1 class="heading-2 text-green mb-1">Mi Perfil</h1>
            <p class="text-muted">Gestiona tu información personal y tus reservas</p>
        </div>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success alert-dismissible fade show animate-slideUp" role="alert">
                ¡Perfil actualizado exitosamente!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="alert alert-success alert-dismissible fade show animate-slideUp" role="alert">
                ¡Contraseña actualizada exitosamente!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-slideUp" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            {{-- Información Personal --}}
            <div class="col-lg-6">
                <div class="card-agrivall h-100">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3 text-green">Información Personal</h2>
                        <p class="text-muted small mb-4">Actualiza tu nombre y correo electrónico</p>

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nombre</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-agrivall-primary w-100">
                                Actualizar Información
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Cambiar Contraseña --}}
            <div class="col-lg-6">
                <div class="card-agrivall h-100">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3 text-green">Cambiar Contraseña</h2>
                        <p class="text-muted small mb-4">Asegúrate de usar una contraseña segura</p>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label fw-semibold">Contraseña Actual</label>
                                <input type="password"
                                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                    id="current_password" name="current_password" required>
                                @error('current_password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Nueva Contraseña</label>
                                <input type="password"
                                    class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                    id="password" name="password" required>
                                @error('password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirmar Nueva
                                    Contraseña</label>
                                <input type="password"
                                    class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation" required>
                                @error('password_confirmation', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-agrivall-primary w-100">
                                Actualizar Contraseña
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mis Reservas --}}
        <div class="mt-4">
            <div class="card-agrivall">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="h5 fw-bold mb-1 text-green">Mis Reservas</h2>
                            <p class="text-muted small mb-0">Gestiona tus reservas de la casa rural</p>
                        </div>
                        <a href="{{ route('reservas.create') }}" class="btn btn-agrivall-primary">
                            + Nueva Reserva
                        </a>
                    </div>

                    @if ($reservas->isEmpty())
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <svg width="64" height="64" fill="currentColor" class="text-muted opacity-50"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                </svg>
                            </div>
                            <h3 class="h6 text-muted mb-2">No tienes reservas</h3>
                            <p class="text-muted mb-3">Crea tu primera reserva para disfrutar de nuestra casa rural</p>
                            <a href="{{ route('reservas.create') }}" class="btn btn-agrivall-secondary">
                                Crear Reserva
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Fechas</th>
                                        <th class="text-center">Personas</th>
                                        <th>Precio Total</th>
                                        <th>Estado</th>
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservas as $reserva)
                                        <tr>
                                            <td class="fw-semibold">#{{ $reserva->id }}</td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span
                                                        class="fw-medium">{{ $reserva->fecha_inicio->format('d/m/Y') }}</span>
                                                    <span class="text-muted small">hasta
                                                        {{ $reserva->fecha_fin->format('d/m/Y') }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark">{{ $reserva->num_personas }}
                                                    {{ $reserva->num_personas > 1 ? 'personas' : 'persona' }}</span>
                                            </td>
                                            <td class="text-green fw-semibold">
                                                ${{ number_format($reserva->precio_total, 2) }}</td>
                                            <td>
                                                @if ($reserva->estado === 'confirmada')
                                                    <span class="badge bg-success">Confirmada</span>
                                                @elseif($reserva->estado === 'pendiente')
                                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                                @elseif($reserva->estado === 'cancelada')
                                                    <span class="badge bg-danger">Cancelada</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('reservas.show', $reserva->id) }}"
                                                        class="btn btn-outline-secondary" title="Ver detalles">
                                                        <svg width="16" height="16" fill="currentColor"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                            <path
                                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                        </svg>
                                                    </a>

                                                    @if ($reserva->estado !== 'cancelada')
                                                        <a href="{{ route('reservas.edit', $reserva->id) }}"
                                                            class="btn btn-outline-primary" title="Editar reserva">
                                                            <svg width="16" height="16" fill="currentColor"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                                            </svg>
                                                        </a>

                                                        <form action="{{ route('reservas.destroy', $reserva->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('¿Estás seguro de que deseas cancelar esta reserva?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger"
                                                                title="Cancelar reserva">
                                                                <svg width="16" height="16" fill="currentColor"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 pt-3 border-top">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="text-center p-3 bg-light rounded">
                                        <div class="h4 mb-1 text-green fw-bold">
                                            {{ $reservas->where('estado', 'confirmada')->count() }}</div>
                                        <div class="small text-muted">Reservas Confirmadas</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-3 bg-light rounded">
                                        <div class="h4 mb-1 text-warning fw-bold">
                                            {{ $reservas->where('estado', 'pendiente')->count() }}</div>
                                        <div class="small text-muted">Reservas Pendientes</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-3 bg-light rounded">
                                        <div class="h4 mb-1 text-green fw-bold">
                                            ${{ number_format($reservas->where('estado', '!=', 'cancelada')->sum('precio_total'), 2) }}
                                        </div>
                                        <div class="small text-muted">Total Invertido</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Mis Pedidos --}}
        <div class="mt-4">
            <div class="card-agrivall">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="h5 fw-bold mb-1 text-green">Mis Pedidos</h2>
                            <p class="text-muted small mb-0">Historial de tus compras</p>
                        </div>
                        <a href="{{ route('productos.catalogo') }}" class="btn btn-agrivall-primary">
                            Ir al Catálogo
                        </a>
                    </div>

                    @if ($pedidos->isEmpty())
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <svg width="64" height="64" fill="currentColor" class="text-muted opacity-50"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                </svg>
                            </div>
                            <h3 class="h6 text-muted mb-2">No tienes pedidos</h3>
                            <p class="text-muted mb-3">Explora nuestro catálogo y realiza tu primer pedido</p>
                            <a href="{{ route('productos.catalogo') }}" class="btn btn-agrivall-secondary">
                                Ver Catálogo
                            </a>
                        </div>
                    @else
                        {{-- Vista móvil: Cards --}}
                        <div class="d-md-none">
                            @foreach ($pedidos as $pedido)
                                <div class="card-agrivall mb-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="fw-bold text-green mb-1">Pedido #{{ $pedido->id }}</h6>
                                                <small
                                                    class="text-muted">{{ $pedido->fecha_pedido->format('d/m/Y H:i') }}</small>
                                            </div>
                                            @php
                                                $badgeClass = match ($pedido->estado) {
                                                    'Iniciado' => 'bg-warning text-dark',
                                                    'En proceso' => 'bg-info',
                                                    'Reparto' => 'bg-primary',
                                                    'Finalizado' => 'bg-success',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $pedido->estado }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span
                                                class="fw-bold text-green fs-5">{{ number_format($pedido->precio_pedido, 2) }}
                                                €</span>
                                            <a href="{{ route('pedidos.show', $pedido) }}"
                                                class="btn btn-agrivall-primary btn-sm">Ver detalle</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Vista desktop: Tabla --}}
                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Pedido</th>
                                        <th>Fecha</th>
                                        <th>Método Pago</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pedidos as $pedido)
                                        <tr>
                                            <td class="fw-semibold">#{{ $pedido->id }}</td>
                                            <td>{{ $pedido->fecha_pedido->format('d/m/Y H:i') }}</td>
                                            <td>{{ $pedido->metodo_pago }}</td>
                                            <td class="text-center fw-bold text-green">
                                                {{ number_format($pedido->precio_pedido, 2) }} €</td>
                                            <td class="text-center">
                                                @php
                                                    $badgeClass = match ($pedido->estado) {
                                                        'Iniciado' => 'bg-warning text-dark',
                                                        'En proceso' => 'bg-info',
                                                        'Reparto' => 'bg-primary',
                                                        'Finalizado' => 'bg-success',
                                                        default => 'bg-secondary',
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $pedido->estado }}</span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('pedidos.show', $pedido) }}"
                                                    class="btn btn-outline-secondary btn-sm" title="Ver detalles">
                                                    <svg width="16" height="16" fill="currentColor"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                        <path
                                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 pt-3 border-top">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="text-center p-3 bg-light rounded">
                                        <div class="h4 mb-1 text-green fw-bold">{{ $pedidos->count() }}</div>
                                        <div class="small text-muted">Total Pedidos</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-3 bg-light rounded">
                                        <div class="h4 mb-1 text-warning fw-bold">
                                            {{ $pedidos->where('estado', 'Iniciado')->count() }}</div>
                                        <div class="small text-muted">Pedidos Iniciados</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-3 bg-light rounded">
                                        <div class="h4 mb-1 text-green fw-bold">
                                            {{ number_format($pedidos->sum('precio_pedido'), 2) }}
                                            €</div>
                                        <div class="small text-muted">Total Gastado</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Zona de Peligro (Opcional) --}}
        <div class="mt-4">
            <div class="card border-danger">
                <div class="card-body p-4">
                    <h2 class="h6 fw-bold mb-2 text-danger">Zona de Peligro</h2>
                    <p class="text-muted small mb-3">Una vez eliminada tu cuenta, todos los datos se perderán
                        permanentemente.</p>

                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteAccountModal">
                        Eliminar Cuenta
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Confirmación de Eliminación --}}
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger" id="deleteAccountModalLabel">¿Eliminar cuenta?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">¿Estás seguro de que deseas eliminar tu cuenta? Todos tus datos y reservas se
                        eliminarán permanentemente. Esta acción no se puede deshacer.</p>

                    <form method="POST" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                        @csrf
                        @method('DELETE')

                        <div class="mb-3">
                            <label for="password_delete" class="form-label fw-semibold">Confirma tu contraseña</label>
                            <input type="password"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                id="password_delete" name="password" required placeholder="Ingresa tu contraseña">
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="deleteAccountForm" class="btn btn-danger">Eliminar Cuenta</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Mostrar modal de eliminación si hay errores de validación
        @if ($errors->userDeletion->isNotEmpty())
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
            deleteModal.show();
        @endif
    </script>
@endpush
