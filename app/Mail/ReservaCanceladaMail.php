<?php

namespace App\Mail;

use App\Models\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservaCanceladaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        protected Reserva $reserva,
        protected bool $admin = false
    ) {
    }

    public function envelope(): Envelope
    {
        $subject = $this->admin
            ? 'Reserva cancelada #' . $this->reserva->id . ' - ' . $this->reserva->usuario->name
            : 'Confirmacion de cancelacion de reserva #' . $this->reserva->id;

        return new Envelope(
            subject: $subject,
            from: new Address(config('mail.from.address'), config('mail.from.name')),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reserva-cancelada',
            with: [
                'reserva' => $this->reserva,
                'usuario' => $this->reserva->usuario,
                'admin' => $this->admin,
            ],
        );
    }
}
