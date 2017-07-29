<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use Translatable;

    public $translatedAttributes = ['title', 'description'];

    protected $fillable = [
        'need', 'prize', 'renew', 'type'
    ];

    public static function getAchievementsInfo ()
    {
        $temp = [];

        $achievements = static::get()->all();

        foreach ($achievements as $achievement) {
            $temp[$achievement->id] = [
                'has' => 0,
                'completed' => 0,
            ];
        }

        return json_encode($temp);
    }
}
