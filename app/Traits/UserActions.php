<?php

namespace App\Traits;


use App\Wish;

trait UserActions
{
    public function topUp($amount)
    {
        $this->increment('balance', $amount);
    }

    public function donate(Wish $wish, $amount)
    {
        $this->decrement('balance', $amount);
        $wish->recordDonation($this->id, $amount);
    }

    public function confirmEmail()
    {
        $this->verified = true;
        $this->token = null;

        $this->save();
    }
}