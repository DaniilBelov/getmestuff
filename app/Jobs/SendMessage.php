<?php

namespace App\Jobs;

use App\Mail\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $body, $subject, $user, $email, $locale;


    /**
     * Create a new job instance.
     * @param $admin
     * @param $body
     * @param $subject
     * @param $user
     * @param $email
     * @param $locale
     */
    public function __construct($body, $subject, $user, $email = null, $locale)
    {
        $this->body = $body;
        $this->subject = $subject;
        $this->user = $user;
        $this->email = $email;
        $this->locale = $locale;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (is_null($this->user)) {
            \Mail::to($this->email)->send(
                new Message($this->body, $this->subject, $this->user, $this->locale
                ));
        } else {
            \Mail::to($this->user)->send(
                new Message($this->body, $this->subject, $this->user, $this->locale
                ));
        }
    }
}
