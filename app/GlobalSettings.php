<?php

namespace App;

use function GuzzleHttp\Promise\queue;
use Illuminate\Database\Eloquent\Model;

class GlobalSettings extends Model
{
    public $timestamps = true;

    protected $fillable = ['setting', 'data'];

    protected $casts = [
        'data' => 'json',
    ];

    public static function getSettings($setting)
    {
        return static::query()->where('setting', $setting)->firstOrFail();
    }

    public static function getSettingsGroup($setting)
    {
        return static::query()->whereIn('setting', $setting)->get();
    }

    public static function getGeneralSetting()
    {
        return static::query()->whereIn('setting', [
            'emails', 'social_media', 'banned_words', 'state'
        ])->get();
    }
}
