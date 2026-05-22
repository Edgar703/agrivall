@extends('layouts.app')

@section('titol', 'Gestión de Usuarios - Admin')

@section('contingut')
    <div class="animate-fadeInUp">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
            <div>
                <h1 class="heading-2 text-green mb-0 fs-3 fs-md-2">Panel de Administración - Usuarios</h1>
            </div>
            {{-- <a href="{{ route('index') }}" class="btn btn-agrivall-secondary btn-sm">
                ← Volver
            </a> --}}
        </div>

        <div class="row g-2 g-md-3 mb-3 mb-md-4">
            <div class="col-6 col-md-4">
                <div class="card-agrivall bg-light">
                    <div class="card-body p-2 p-md-3">
                        <p class="text-muted mb-1 small">Total usuarios</p>
                        <h3 class="text-green mb-0 fs-5 fs-md-4">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="card-agrivall bg-light">
                    <div class="card-body p-2 p-md-3">
                        <p class="text-muted mb-1 small">Administradores</p>
                        <h3 class="text-warning mb-0 fs-5 fs-md-4">{{ $stats['admins'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card-agrivall bg-light">
                    <div class="card-body p-2 p-md-3">
                        <p class="text-muted mb-1 small">Con reservas</p>
                        <h3 class="text-success mb-0 fs-5 fs-md-4">{{ $stats['con_reservas'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-agrivall mb-3">
            <div class="card-body p-3">
                <form method="GET" action="{{ route('admin.usuarios.index') }}" class="row g-2 align-items-end">
                    <div class="col-12 col-md-5">
                        <label for="q" class="form-label-agrivall small">Buscar</label>
                        <input type="text" id="q" name="q" class="form-control-agrivall form-control-sm"
                            value="{{ request('q', $search ?? '') }}" placeholder="Ej: juan o juan@email.com">
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="role" class="form-label-agrivall small">Rol</label>
                        <select id="role" name="role" class="form-control-agrivall form-control-sm">
                            <option value="">Todos</option>
                            <option value="user" @selected(request('role', $role ?? '') === 'user')>Usuario</option>
                            <option value="admin" @selected(request('role', $role ?? '') === 'admin')>Admin</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4 d-flex flex-column flex-sm-row gap-2">
                        <button type="submit" class="btn btn-agrivall-primary btn-sm">Filtrar</button>
                        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-agrivall-secondary btn-sm">Limpiar filtros</a>
                    </div>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($usuarios->count() === 0)
            <div class="alert alert-info" role="alert">
                No se han encontrado usuarios con los filtros actuales.
            </div>
        @else
            <div class="d-md-none">
                @foreach ($usuarios as $usuario)
                    <div class="card-agrivall mb-3 usuario-item"
                        data-filter-text="{{ strtolower(trim($usuario->id . ' ' . $usuario->name . ' ' . $usuario->email . ' ' . $usuario->role . ' ' . $usuario->reservas_count)) }}">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="fw-bold text-green mb-1">{{ $usuario->name }}</h5>
                                    <p class="text-muted small mb-0">{{ $usuario->email }}</p>
                                </div>
                                @if ($usuario->role === 'admin')
                                    <span class="badge bg-warning text-dark">Admin</span>
                                @else
                                    <span class="badge bg-secondary">Usuario</span>
                                @endif
                            </div>

                            <p class="small mb-2">
                                <span class="text-muted">Reservas:</span> {{ $usuario->reservas_count }}
                            </p>

                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.usuarios.show', $usuario->id) }}"
                                    class="btn btn-info btn-sm flex-fill">Ver</a>
                                <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
                                    class="btn btn-warning btn-sm flex-fill">Editar</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="table-agrivall d-none d-md-block">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Reservas</th>
                            <th>Alta</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr class="usuario-item"
                                data-filter-text="{{ strtolower(trim($usuario->id . ' ' . $usuario->name . ' ' . $usuario->email . ' ' . $usuario->role . ' ' . $usuario->reservas_count)) }}">
                                <td class="fw-semibold">#{{ $usuario->id }}</td>
                                <td><a href="{{ route('admin.usuarios.show', $usuario->id) }}">{{ $usuario->name }}</a>
                                </td>

                                <td>{{ $usuario->email }}</td>
                                <td>
                                    @if ($usuario->role === 'admin')
                                        <span class="badge bg-warning text-dark">Admin</span>
                                    @else
                                        <span class="badge bg-secondary">Usuario</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $usuario->reservas_count }}</td>
                                <td class="text-muted small">{{ optional($usuario->created_at)->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm gap-2">
                                        <a href="{{ route('admin.usuarios.show', $usuario->id) }}"
                                            class="btn btn-info rounded">Ver</a>
                                        <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
                                            class="btn btn-warning rounded">Editar</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mt-3">
                <p class="text-muted small mb-0">
                    Mostrando {{ $usuarios->firstItem() }}-{{ $usuarios->lastItem() }} de {{ $usuarios->total() }}
                    usuarios
                </p>
                <div>
                    {{ $usuarios->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            const setupUsuariosFilter = function() {
                const searchInput = document.getElementById('q');
                const usuarioItems = document.querySelectorAll('.usuario-item');

                if (searchInput && usuarioItems.length > 0) {
                    searchInput.addEventListener('input', function() {
                        const searchValue = this.value.toLowerCase().trim();

                        usuarioItems.forEach(item => {
                            const filterText = item.dataset.filterText || '';
                            const shouldShow = searchValue === '' || filterText.includes(searchValue);
                            item.style.display = shouldShow ? '' : 'none';
                        });
                    });
                }
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', setupUsuariosFilter);
            } else {
                setupUsuariosFilter();
            }
        </script>
    @endpush
@endsection
