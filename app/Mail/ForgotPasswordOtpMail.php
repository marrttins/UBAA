<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordOtpMail extends Mailable
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
            subject: '🔑 Password Reset Code: ' . $this->otp . ' | UBAA Lagos',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.forgot-password-otp',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
