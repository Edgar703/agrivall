<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Si ya estaba verificado, redirigir al inicio
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('index', absolute: false).'?verified=1');
        }

        // Marcar email como verificado y lanzar evento
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Redirigir al inicio con marca de verificado
        return redirect()->intended(route('index', absolute: false).'?verified=1');
    }
}
