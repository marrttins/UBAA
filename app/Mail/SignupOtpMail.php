<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SignupOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstName;
    public $otp;
    public $expiresInMinutes;

    public function __construct($firstName, $otp, $expiresInMinutes = 15)
    {
        $this->firstName = $firstName;
        $this->otp = $otp;
        $this->expiresInMinutes = $expiresInMinutes;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Email Address | UBAA Lagos',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.signup-otp',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
