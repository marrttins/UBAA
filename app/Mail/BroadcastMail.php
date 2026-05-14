<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BroadcastMail extends Mailable
{
    use Queueable, SerializesModels;

    public $broadcastSubject;
    public $broadcastMessage;
    public $recipientName;

    public function __construct($subject, $message, $recipientName = 'Member')
    {
        $this->broadcastSubject = $subject;
        $this->broadcastMessage = $message;
        $this->recipientName = $recipientName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->broadcastSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.broadcast',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
