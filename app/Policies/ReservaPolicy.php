<?php

namespace App\Policies;

use App\Models\Reserva;
use App\Models\Usuario;

class ReservaPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(Usuario $user, Reserva $reserva): bool
    {
        // El admin puede ver cualquier reserva
        if ($user->role === 'admin') {
            return true;
        }

        // El usuario solo puede ver sus propias reservas
        return $user->id === $reserva->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Usuario $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Usuario $user, Reserva $reserva): bool
    {
        // Solo admin puede actualizar reservas
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $user, Reserva $reserva): bool
    {
        // El usuario puede cancelar su propia reserva
        if ($user->role !== 'admin' && $user->id === $reserva->user_id) {
            return true;
        }

        // El admin puede cancelar cualquier reserva
        return $user->role === 'admin';
    }
}
