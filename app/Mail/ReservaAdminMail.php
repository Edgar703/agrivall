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
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🏡 Nueva solicitud de reserva #' . $this->reserva->id . ' — Agrivall',
            from: new Address(config('mail.from.address'), config('mail.from.name')),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reserva-admin',
            with: [
                'reserva' => $this->reserva,
                'usuario' => $this->reserva->usuario,
            ],
        );
    }
}
