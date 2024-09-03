<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BlogPosted extends Notification
{
    use Queueable;

    protected $post;
    protected $message;
    /**
     * Create a new notification instance.
     */
    public function __construct($post, $message)
    {
        $this->post = $post;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('A new blog has been published by ' . $this->post->user->name)
                    ->action('Read Blog', url('/blogposts/' . $this->post->id))
                    ->line('Thank you for following us!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'blogger_id' => $this->post->user->id,
            'blogger_name' => $this->post->user->name,
            'blogger_profile' => $this->post->user->profile,
            'message' => $this->message,
            'created_at' => $this->post->created_at,
        ];
    }
}
