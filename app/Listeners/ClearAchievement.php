<?php

namespace App\Listeners;

use App\Events\AchievementsOutdated;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClearAchievement implements ShouldQueue
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
     * @param  AchievementsOutdated  $event
     * @return void
     */
    public function handle(AchievementsOutdated $event)
    {
        $event->user->clearAchievements();
    }
}
