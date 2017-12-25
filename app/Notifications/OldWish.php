<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OldWish extends Notification
{
    use Queueable;

    protected $wish, $priority;

    public function __construct($wish, $priority)
    {
        $this->wish = $wish;
        $this->priority = $priority;
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

    public function toMail($notifiable)
    {
        $subject = ($this->wish->user->locale == 'en') ? 'One Month Notification' : 'Желание активно один месяц';

        return (new MailMessage)
            ->subject($subject)
            ->view("email.{$this->wish->user->locale}.old", ['wish' => $this->wish, 'priority' => $this->priority]);
    }
}
