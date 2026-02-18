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
        abort_unless(Auth::check() && Auth::user()->role === 'admin', 403);
    }

    public function index(Request $request): View
    {
        $this->ensureAdmin();

        $search = trim((string) $request->query('q', ''));
        $role = (string) $request->query('role', '');

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

        $stats = [
            'total' => Usuario::count(),
            'admins' => Usuario::where('role', 'admin')->count(),
            'con_reservas' => Usuario::has('reservas')->count(),
        ];

        return view('admin.usuarios.index', compact('usuarios', 'stats', 'search', 'role'));
    }

    public function show(Usuario $usuario): View
    {
        $this->ensureAdmin();

        $reservas = $usuario->reservas()
            ->orderBy('created_at', 'desc')
            ->get();

        $comprasDisponibles = Schema::hasTable('pedidos');

        $compras = collect();

        if ($comprasDisponibles) {
            $compras = DB::table('pedidos')
                ->where('email_cliente', $usuario->email)
                ->orderByDesc('fecha_pedido')
                ->get();
        }

        return view('admin.usuarios.show', compact('usuario', 'reservas', 'compras', 'comprasDisponibles'));
    }

    public function edit(Usuario $usuario): View
    {
        $this->ensureAdmin();

        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario): RedirectResponse
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('usuarios', 'email')->ignore($usuario->id)],
            'role' => ['required', Rule::in(['user', 'admin'])],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validated['email'] !== $usuario->email) {
            $usuario->email_verified_at = null;
        }

        $usuario->name = $validated['name'];
        $usuario->email = $validated['email'];
        $usuario->role = $validated['role'];

        if (!empty($validated['password'])) {
            $usuario->password = Hash::make($validated['password']);
        }

        $usuario->save();

        return redirect()
            ->route('admin.usuarios.show', $usuario)
            ->with('success', 'Datos del usuario actualizados correctamente.');
    }
}
