<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        // Si el email ya está verificado, redirigir al inicio
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('index', absolute: false));
        }

        // Enviar email de verificación
        $request->user()->sendEmailVerificationNotification();

        // Volver con mensaje de enlace enviado
        return back()->with('status', 'verification-link-sent');
    }
}
