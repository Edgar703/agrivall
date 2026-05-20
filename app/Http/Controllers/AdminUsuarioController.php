<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUsuarioController extends Controller
{
    private function ensureAdmin(): void
    {
        // Comprobar que el usuario logueado sea admin
        abort_unless(Auth::check() && Auth::user()->role === 'admin', 403);
    }

    public function index(Request $request): View
    {
        // Solo admins pueden ver esta pantalla
        $this->ensureAdmin();

        // Capturar filtros de búsqueda
        $search = trim((string) $request->query('q', ''));
        $role = (string) $request->query('role', '');

        // Buscar usuarios con filtros opcionales
        $usuarios = Usuario::query()
            ->withCount('reservas')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when(in_array($role, ['user', 'admin'], true), function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Calcular estadísticas para el panel
        $stats = [
            'total' => Usuario::count(),
            'admins' => Usuario::where('role', 'admin')->count(),
            'con_reservas' => Usuario::has('reservas')->count(),
        ];

        // Mostrar listado de usuarios
        return view('admin.usuarios.index', compact('usuarios', 'stats', 'search', 'role'));
    }

    public function show(Usuario $usuario): View
    {
        // Solo admins pueden ver el detalle
        $this->ensureAdmin();

        // Cargar reservas del usuario
        $reservas = $usuario->reservas()
            ->orderBy('created_at', 'desc')
            ->get();

        // Comprobar si existe tabla de pedidos
        $comprasDisponibles = Schema::hasTable('pedidos');

        $compras = collect();

        // Si hay pedidos, buscar compras por email del usuario
        if ($comprasDisponibles) {
            $compras = DB::table('pedidos')
                ->where('email_cliente', $usuario->email)
                ->orderByDesc('fecha_pedido')
                ->get();
        }

        // Mostrar detalle del usuario
        return view('admin.usuarios.show', compact('usuario', 'reservas', 'compras', 'comprasDisponibles'));
    }

    public function edit(Usuario $usuario): View
    {
        // Solo admins pueden editar usuarios
        $this->ensureAdmin();

        // Mostrar formulario de edición
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario): RedirectResponse
    {
        // Solo admins pueden actualizar usuarios
        $this->ensureAdmin();

        // Validar datos del formulario
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('usuarios', 'email')->ignore($usuario->id)],
            'role' => ['required', Rule::in(['user', 'admin'])],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Si cambia el email, marcarlo como no verificado
        if ($validated['email'] !== $usuario->email) {
            $usuario->email_verified_at = null;
        }

        // Actualizar datos básicos
        $usuario->name = $validated['name'];
        $usuario->email = $validated['email'];
        $usuario->role = $validated['role'];

        // Cambiar contraseña solo si se ha escrito una nueva
        if (!empty($validated['password'])) {
            $usuario->password = Hash::make($validated['password']);
        }

        // Guardar cambios
        $usuario->save();

        // Volver al detalle del usuario
        return redirect()
            ->route('admin.usuarios.show', $usuario)
            ->with('success', 'Datos del usuario actualizados correctamente.');
    }
}
