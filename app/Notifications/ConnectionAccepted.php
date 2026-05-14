<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ConnectionAccepted extends Notification
{
    use Queueable;

    protected $receiver;

    /**
     * Create a new notification instance.
     */
    public function __construct($receiver)
    {
        $this->receiver = $receiver;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'sender_id' => $this->receiver->id,
            'sender_name' => $this->receiver->name,
            'sender_avatar' => $this->receiver->avatar_url,
            'title' => 'Connection Accepted',
            'icon' => 'fa-handshake',
            'message' => $this->receiver->name . " accepted your connection request! You are now connected.",
            'action_url' => route('profile'),
            'type' => 'connection_accepted'
        ];
    }

}
