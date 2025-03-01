<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public function __construct($data, $link)
    {
        $this->data = $data;
        $this->link = $link;
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('setting.email_from'),config('setting.app_name')),
            subject: __('word.reset_password_email.subject',['app_name'=>config('setting.app_name')]),
        );
    }
    public function content(): Content
    {
        return new Content(
            view: 'forgot_password.forgot_password_mail',
            with: [
                'data' => $this->data,
                'link' => $this->link,
            ],
        );
    }
    public function attachments(): array
    {
        return [];
    }
}
