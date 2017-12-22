<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $lang;


    /**
     * Create a new message instance.
     *
     * @param $user
     */
    public function __construct($user, $lang)
    {
        $this->user = $user;
        $this->lang = $lang;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = ($this->locale == 'en') ? 'Email Verification' : 'Подтверждение Электронной Почты';

        return $this->view("email.{$this->lang}.verify")
                    ->subject($subject);
    }
}
