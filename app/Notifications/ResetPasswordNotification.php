<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token, $isAdmin, $locale;

    /**
     * Create a new notification instance.
     *
     * @param $token
     * @param $isAdmin
     * @param $locale
     */
    public function __construct($token, $isAdmin, $locale)
    {
        $this->token = $token;
        $this->isAdmin = $isAdmin;
        $this->locale = $locale;
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
        if ($this->isAdmin) $url = url(config('app.url').route('password.reset.admin', $this->token, false));
        else $url = url(config('app.url').route('password.reset', $this->token, false));

        $subject = ($this->locale == 'en') ? 'Password Reset' : 'Восстановление пароля';
        
        return (new MailMessage)->view("email.{$this->locale}.reset", ['url' => $url])->subject($subject);
    }
}
