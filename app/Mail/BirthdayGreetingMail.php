<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BirthdayGreetingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $celebrant;

    public function __construct($celebrant)
    {
        $this->celebrant = $celebrant;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎂 Happy Birthday ' . $this->celebrant->first_name . '! | UBAA Lagos',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.birthday-greeting',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
