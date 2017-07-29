<?php

namespace App\Inspections;


use App\GlobalSettings;

class BannedWords
{
    protected $banned;

    public function __construct()
    {
        $settings = GlobalSettings::getSettings('banned_words')->data;

        $this->banned = '/'.implode('|', $settings).'/i';
    }

    public function detect($body)
    {
        if (preg_match($this->banned, $body)) {
            throw new \Exception('You cannot wish for that.');
        }
    }
}