@extends('layouts.app')

@section('titol', 'Editar Usuario - Admin')

@section('contingut')
    <div class="animate-fadeInUp">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
            <div>
                <h1 class="heading-2 text-green mb-0 fs-3 fs-md-2">Editar usuario #{{ $usuario->id }}</h1>
            </div>
            <a href="{{ route('admin.usuarios.show', $usuario->id) }}" class="btn btn-agrivall-secondary btn-sm">
                ← Volver
            </a>
        </div>

        <div class="card-agrivall">
            <div class="card-body p-3 p-md-4">
                <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PATCH')

                    <div class="col-md-6">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name', $usuario->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control"
                            value="{{ old('email', $usuario->email) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="role" class="form-label">Rol</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="user" @selected(old('role', $usuario->role) === 'user')>Usuario</option>
                            <option value="admin" @selected(old('role', $usuario->role) === 'admin')>Admin</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="password" class="form-label">Nueva contraseña (opcional)</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                    </div>

                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-agrivall-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
