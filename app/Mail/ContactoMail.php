<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected array $datos
    ) {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo mensaje de contacto: ' . $this->datos['asunto'],
            from: new Address($this->datos['email'], $this->datos['nombre']),
            replyTo: [
                new Address($this->datos['email'], $this->datos['nombre']),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contacto',
            with: [
                'nombre' => $this->datos['nombre'],
                'email' => $this->datos['email'],
                'telefono' => $this->datos['telefono'],
                'asunto' => $this->datos['asunto'],
                'mensaje' => $this->datos['mensaje'],
            ],
        );
    }
}
