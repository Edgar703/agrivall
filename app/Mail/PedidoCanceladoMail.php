<?php

namespace App\Mail;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PedidoCanceladoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        protected Pedido $pedido,
        protected bool $admin = false
    ) {
    }

    public function envelope(): Envelope
    {
        $subject = $this->admin
            ? 'Pedido cancelado #' . $this->pedido->id . ' - ' . $this->pedido->nombre_cliente
            : 'Confirmacion de cancelacion de pedido #' . $this->pedido->id;

        return new Envelope(
            subject: $subject,
            from: new Address(config('mail.from.address'), config('mail.from.name')),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pedido-cancelado',
            with: [
                'pedido' => $this->pedido,
                'lineas' => $this->pedido->lineas,
                'admin' => $this->admin,
            ],
        );
    }
}
