<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class recuperarContraseña extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre; 
    public $usuario;

    /**
     * Create a new message instance.
     */
    public function __construct($nombre, $usuario)
    {
        $this->nombre = $nombre;
        $this->usuario = $usuario;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('administracion@sncs.com','Administrador Académico'),
            subject: 'Solicitud para recuperar contraseña',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.recuperarContraseña',
            with: [
                'nombre' => $this->nombre,
                'usuario' => $this->usuario,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
