<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserHasDonated extends Notification
{
    use Queueable;

    protected $wish, $amount;


    /**
     * Create a new notification instance.
     *
     * @param $wish
     * @param $amount
     */
    public function __construct($wish, $amount)
    {
        $this->wish = $wish;
        $this->amount = $amount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'wish' => $this->wish->translate('en')->item,
            'amount' => $this->amount
        ];
    }
}
