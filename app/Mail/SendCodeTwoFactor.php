<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class SendCodeTwoFactor extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function envelope(): Envelope
    {
        //SETEAMOS LA CONFIGURACION DE NUESTRO CORREO ELECTRONICO
        return new Envelope(
            from: new Address(config('setting.email_from'),config('setting.app_name')),
            subject: __('word.two_factor.email.code',['app_name'=>config('setting.app_name')]),
        );
    }
    public function content(): Content
    {
        return new Content(
            view: 'two_factor.two_factor_mail',
            with: $this->data,
        );
    }
    public function attachments(): array
    {
        return [];
    }
}
