<?php


namespace App\Traits;

use App\Achievement;
use App\GlobalSettings;
use App\User;
use Carbon\Carbon;

trait UserAchievements
{
    protected $prize = 0;
    protected $ref_prize = 0;

    protected $allAchievements;

    public function recordAchievements($amount, $types, $ref = false)
    {
        if (!GlobalSettings::getSettings('disable_achievements')->data['on'])
            return;

        if (cache("user.{$this->id}")->lte(Carbon::now())) {
            $this->clearAchievements($this);
        }

        $userAchievements = $this->checkAchievements();

        $achievements = $this->getAchievementsInfo();

        foreach ($types as $type) {
            $this->allAchievements = $achievements[$type];
            $userAchievements = $this->overrideAchievements($amount, $userAchievements);
        }

        $this->achievements = $userAchievements;
        $this->points += $this->prize;
        $this->save();

        if ($ref) $this->recordRefAchievements($ref);
    }

    protected function cacheNewDate($user)
    {
        $key = sprintf("user.%s", $user->id);
        \Cache::forever($key, Carbon::now()->addMonth());
    }

    public function clearAchievements($user)
    {
        $userAchievements = collect(json_decode($user->achievements, true));

        $this->allAchievements = $this->getAchievementsInfo(false)->keyBy(function ($item) {
            return $item->id;
        });

        $userAchievements = $userAchievements->map(function ($item, $key) {
            if ($checker = $this->checkKey($key)) {
                if ($checker->renew == 1) {
                    $item['has'] = 0;
                    $item['completed'] = 0;
                }
            }
            return $item;
        });

        $user->achievements = $userAchievements;
        $user->save();

        $user->cacheNewDate($user);
    }


    protected function recordRefAchievements($ref)
    {
        $referral = User::query()->where('ref_link', '=', $ref)->first();

        $this->clearAchievements($referral);

        $refAchievements = collect(json_decode($referral->achievements, true));

        $achievements = $this->getAchievementsInfo();

        $this->allAchievements = $achievements[5];
        $this->prize = 0;

        $refAchievements = $this->overrideAchievements(1, $refAchievements);

        $referral->achievements = $refAchievements;
        $referral->points += $this->prize;
        $referral->save();
    }

    protected function checkKey($key)
    {
        $temp = collect($this->allAchievements)->filter(function ($item) use ($key) {
            return ($item->id == $key);
        });

        if ($temp->isEmpty()) return false;

        return $temp->first();
    }

    protected function recordStaticAchievements($checker, $item, $amount)
    {
        if ($checker->need <= $amount) {
            $this->prize += $checker->prize;
            $item['completed'] = 1;
        } else if ($item['has'] >= $amount) {
            return $item;
        } else {
            $item['has'] = $amount;
        }
        return $item;
    }

    protected function recordOngoingAchievements($checker, $item, $amount)
    {
        if ($item['completed'] == 1) {
            return $item;
        } else if ($checker->need <= ($item['has'] + $amount)) {
            $this->prize += $checker->prize;
            $item['has'] = $checker->need;
            $item['completed'] = 1;
        } else {
            $item['has'] += $amount;
        }
        return $item;
    }

    protected function overrideAchievements($amount, $achievements)
    {
        $achievements = $achievements->map(function ($item, $key) use ($amount) {
            if ($checker = $this->checkKey($key)) {
                if ($checker->renew == 2) return $this->recordStaticAchievements($checker, $item, $amount);
                return $this->recordOngoingAchievements($checker, $item, $amount);
            } else {
                return $item;
            }
        });
        return $achievements;
    }

    protected function getAchievementsInfo($group = true)
    {
        $achievements = Achievement::all();

        if ($group) {
            $achievements = $achievements->groupBy(function ($item) {
                return $item->type;
            });
        }

        return $achievements;
    }

    protected function checkAchievements()
    {
        $userAchievements = collect(json_decode($this->achievements, true));

        $achievements = $this->getAchievementsInfo(false)->keyBy(function ($item) {
            return $item->id;
        });

        $userAchievements->diffKeys($achievements)->keys()->each(function ($item) use ($userAchievements) {
            $userAchievements->forget($item);
        });

        $achievements->diffKeys($userAchievements)->keys()->each(function ($item) use ($userAchievements) {
            $userAchievements->put($item, ['has' => 0, 'completed' => 0]);
        });

        return $userAchievements;
    }
}