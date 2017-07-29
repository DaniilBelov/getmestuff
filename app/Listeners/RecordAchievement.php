<?php

namespace App\Listeners;

use App\Events\UserHasDonated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecordAchievement
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserHasDonated  $event
     * @return void
     */
    public function handle(UserHasDonated $event)
    {
        $event->user->amount_donated += $event->amount;

        if ($event->user->donated == 0) {
            $event->user->recordAchievements($event->amount, [1, 4], $event->user->ref_id);
            $event->user->donated = 1;
        } else {
            $event->user->recordAchievements($event->amount, [4]);
        }

        $event->user->save();
    }
}
