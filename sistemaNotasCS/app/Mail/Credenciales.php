<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Credenciales extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre; 
    public $usuario;
    public $pass;

    /**
     * Create a new message instance.
     */
    public function __construct($nombre, $usuario, $pass)
    {
        $this->nombre = $nombre;
        $this->usuario = $usuario;
        $this->pass = $pass;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('administracion@sncs.com','Administrador Académico'),
            subject: 'Credenciales para ingreso al sistema de notas',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.credencialesIngreso',
            with: [
                'nombre' => $this->nombre,
                'usuario' => $this->usuario,
                'pass' => $this->pass
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
