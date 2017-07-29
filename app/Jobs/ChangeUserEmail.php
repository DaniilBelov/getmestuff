<?php

namespace App\Jobs;

use App\Mail\EmailChange;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ChangeUserEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var
     */
    protected $user, $email, $locale;

    /**
     * Create a new job instance.
     *
     * @param $user
     * @param $email
     * @param $locale
     */
    public function __construct($user, $email, $locale)
    {
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
        $token = str_random(30);

        \DB::table('email_resets')
            ->insert([
                'user_id' => $this->user->id,
                'new_email' => $this->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

        \Mail::to($this->email)->send(new EmailChange($this->user, $token, $this->locale));
    }
}
