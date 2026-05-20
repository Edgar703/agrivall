<?php

namespace App\Mail;

use App\Models\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservaAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        protected Reserva $reserva
    ) {
        // Guardar reserva para el email del admin
    }

    public function envelope(): Envelope
    {
        // Preparar asunto y remitente del email
        return new Envelope(
            subject: '🏡 Nueva solicitud de reserva #' . $this->reserva->id . ' — Agrivall',
            from: new Address(config('mail.from.address'), config('mail.from.name')),
        );
    }

    public function content(): Content
    {
        // Enviar reserva y usuario a la vista del email
        return new Content(
            view: 'emails.reserva-admin',
            with: [
                'reserva' => $this->reserva,
                'usuario' => $this->reserva->usuario,
            ],
        );
    }
}
