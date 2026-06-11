<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ipAddress;
    public $userAgent;
    public $time;

    public function __construct($user, $ipAddress, $userAgent, $time)
    {
        $this->user = $user;
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
        $this->time = $time;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔒 Security Alert: New Login Detected | UBAA Lagos',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.login-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
