<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FollowNotification extends Notification
{
    use Queueable;
    protected $follower;
    protected $message;
    /**
     * Create a new notification instance.
     */
    public function __construct($follower,$message)
    {
        $this->follower = $follower;
        $this->message = $message;
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

   
    public function toArray(object $notifiable): array
    {
        return [
            'follower_id' => $this->follower->id,
            'follower_name' => $this->follower->name,
            'follower_profile' => $this->follower->profile,
            'message' => $this->message,
            'created_at' => $this->follower->created_at,
        ];
    }
}
