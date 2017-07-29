<?php

namespace  App\Inspections;

use App\Rules\SpamFree;

class Spam
{
    protected $inspections = [
        BannedWords::class,
        KeyHeldDown::class,
    ];

    public function detect($body)
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }
}