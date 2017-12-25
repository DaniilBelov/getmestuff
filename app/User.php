<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use App\Traits\UserAchievements;
use App\Traits\UserActions;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, UserActions, UserAchievements;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->achievements = Achievement::getAchievementsInfo();
        });

        static::created(function ($user) {
            $key = sprintf("user.%s", $user->id);
            \Cache::forever($key, Carbon::now()->addMonth());
            $this->prize($user);

           // Country::updateCountry($user->id);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'token',
        'verified', 'balance', 'status', 'address', 'donated',
        'allowed_wishes', 'number_of_wishes', 'ref_link', 'ref_id',
        'priority', 'amount_donated', 'amount_received', 'points', 'admin',
        'locale'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'ip_address', 'token', 'verified'
    ];

    protected $casts = [
        'address' => 'json',
        'admin' => 'boolean',
    ];

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $isAdmin = $this->isAdmin();
        $locale = $this->locale;
        $this->notify(new ResetPasswordNotification($token, $isAdmin, $locale));
    }

    /**
     * @return Settings
     */
    public function settings()
    {
        return new Settings($this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wishes()
    {
        return $this->hasMany(Wish::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public static function getRefs()
    {
        $refs =  \DB::table('users')->where([
            ['ref_id', '=', auth()->user()->ref_link],
            ['verified', '=', 1],
            ['donated', '=', 1]
        ])->get();

        $ref_count = $refs->count();

        $ref_table = $refs->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('m-y');
        })->slice(0, 3)->map(function ($item) {
            return collect($item)->count();
        });

        return [
            'count' => $ref_count,
            'table' => $ref_table
        ];
    }

    public static function cacheKey()
    {
        return sprintf("user.%s", auth()->id());
    }

    public function isAdmin()
    {
        return $this->admin;
    }

    public static function ban($email)
    {
        static::query()->where('email', $email)->update(['status' => 0]);
    }

    public static function unban($email)
    {
        static::query()->where('email', $email)->update(['status' => 1]);
    }

    public function prize($user)
    {
        $points = 200;

        switch (true) {
            case $user->id <= 7:
                $user->donated = 1;
                $points += 100;
            case $user->id <= 12:
                $user->number_of_wishes = 2;
                $points += 100;
            case $user->id <= 52:
                $user->priority = 1;
                $points += 100;
            default:
                break;
        }
        
        $user->points = $points;
        $user->save();
        return;
    }
}
