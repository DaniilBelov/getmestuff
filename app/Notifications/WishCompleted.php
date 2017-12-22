<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WishCompleted extends Notification
{
    use Queueable;

    protected $wish;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($wish)
    {
        $this->wish = $wish;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = ($this->wish->user->locale == 'en') ? 'Wish Completed' : 'Желание Выполненно';

        return (new MailMessage)
            ->subject($subject)
            ->view("email.{$this->wish->user->locale }.completed", ['wish' => $this->wish]);
    }
}
