<?php

namespace App\Mail;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PedidoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        protected Pedido $pedido,
        protected bool $admin = false
    ) {
        // Guardar pedido y si el email es para admin
    }

    public function envelope(): Envelope
    {
        // Crear asunto diferente para admin o cliente
        $subject = $this->admin
            ? 'Nuevo pedido #' . $this->pedido->id . ' - ' . $this->pedido->nombre_cliente
            : 'Confirmacion de tu pedido #' . $this->pedido->id;

        // Preparar datos principales del email
        return new Envelope(
            subject: $subject,
            from: new Address(config('mail.from.address'), config('mail.from.name')),
        );
    }

    public function content(): Content
    {
        // Enviar pedido, líneas y tipo de email a la vista
        return new Content(
            view: 'emails.pedido',
            with: [
                'pedido' => $this->pedido,
                'lineas' => $this->pedido->lineas,
                'admin' => $this->admin,
            ],
        );
    }
}
