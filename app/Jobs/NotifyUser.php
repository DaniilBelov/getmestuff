<?php

namespace App\Jobs;

use App\Notifications\UserHasDonated;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $wish;
    protected $amount;

    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->wish->user->increment('amount_received', $this->amount);
        $this->wish->user->notify(new UserHasDonated($this->wish, $this->amount));
    }
}
