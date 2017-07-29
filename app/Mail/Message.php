<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Message extends Mailable
{
    use Queueable, SerializesModels;

    public $admin, $body, $user, $locale;


    /**
     * Create a new message instance.
     *
     * @param $admin
     * @param $body
     * @param $subject
     * @param $user
     * @param $locale
     */
    public function __construct($body, $subject, $user, $locale)
    {
        $this->body = $body;
        $this->subject = $subject;
        $this->user = $user;
        $this->locale = $locale;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view("email.{$this->locale}.reply")
                    ->subject($this->subject);
    }
}
