<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Obtener usuario logueado
        $user = $request->user();

        // Cargar reservas del usuario ordenadas por fecha
        $reservas = $user->reservas()
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        // Cargar pedidos del usuario ordenados por fecha
        $pedidos = $user->pedidos()
            ->orderBy('fecha_pedido', 'desc')
            ->get();

        // Mostrar perfil con reservas y pedidos
        return view('profile.edit', [
            'user' => $user,
            'reservas' => $reservas,
            'pedidos' => $pedidos,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Rellenar usuario con los datos validados
        $request->user()->fill($request->validated());

        // Si cambia el email, marcarlo como no verificado
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Guardar cambios del perfil
        $request->user()->save();

        // Volver al perfil con mensaje
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validar contraseña antes de borrar cuenta
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Obtener usuario logueado
        $user = $request->user();

        // Cerrar sesión antes de borrar
        Auth::logout();

        // Eliminar usuario
        $user->delete();

        // Invalidar sesión y regenerar token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigir al inicio
        return Redirect::to('/');
    }
}
