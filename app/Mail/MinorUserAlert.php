<?php

namespace App\Mail;

use App\Models\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MinorUserAlert extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Usuario $usuario,
        public string  $event // 'created' | 'updated'
    ) {}

    public function build()
    {
        $subject = $this->event === 'created'
            ? 'Alerta: Usuario menor creado'
            : 'Alerta: Usuario menor actualizado';

        return $this->subject($subject)
            ->markdown('emails.minor_user_alert', [
                'usuario' => $this->usuario,
                'event'   => $this->event,
            ]);
    }
}
