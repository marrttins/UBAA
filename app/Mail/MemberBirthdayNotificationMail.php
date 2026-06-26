<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MemberBirthdayNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $celebrant;
    public $recipient;

    /**
     * Create a new message instance.
     */
    public function __construct($celebrant, $recipient)
    {
        $this->celebrant = $celebrant;
        $this->recipient = $recipient;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎉 Join us in celebrating ' . $this->celebrant->name . '\'s birthday today! | UBAA Lagos',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.member-birthday-notification',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
