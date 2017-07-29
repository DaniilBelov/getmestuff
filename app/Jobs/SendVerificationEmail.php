<?php

namespace App\Jobs;

use App\Mail\EmailChange;
use App\Mail\EmailConfirmation;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendVerificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user, $lang;

    /**
     * SendVerificationEmail constructor.
     *
     * @param $user
     * @param $lang
     */
    public function __construct($user, $lang)
    {
        $this->user = $user;
        $this->lang = $lang;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Mail::to($this->user)->send(new EmailConfirmation($this->user, $this->lang));
    }
}
