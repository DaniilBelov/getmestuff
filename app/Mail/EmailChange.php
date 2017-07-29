<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailChange extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $token, $locale;

    /**
     * Create a new message instance.
     *
     * @param $token
     * @param $locale
     */
    public function __construct($user, $token, $locale)
    {
        $this->user = $user;
        $this->token = $token;
        $this->locale = $locale;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view("email.{$this->locale}.change_email")
                    ->subject('Confirm Email Change');
    }
}
