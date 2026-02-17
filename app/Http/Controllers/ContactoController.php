<?php

namespace App\Http\Controllers;

use App\Mail\ContactoMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function mostrar()
    {
        return view('contactar');
    }

    public function enviar(Request $request)
    {
        // Validar los datos del formulario
        $validado = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string|min:10|max:5000',
        ]);

        try {
            // Enviar el correo al administrador
            Mail::to('edgmormel@gmail.com')
                ->send(new ContactoMail($validado));

            return redirect()->route('contactar')->with('success', '¡Tu mensaje ha sido enviado correctamente! Nos pondremos en contacto pronto.');
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de contacto: ' . $e->getMessage());
            return redirect()->route('contactar')->with('error', 'Hubo un error al enviar tu mensaje. Por favor, intenta nuevamente.');
        }
    }
}
