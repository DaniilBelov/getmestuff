<?php

namespace App;


use App\Jobs\ChangeUserEmail;

class Settings
{
    protected $user;

    /**
     * Settings constructor.
     * @param User $user
     */
    public function __construct (User $user)
    {
        $this->user = $user;
    }

    /**
     * @param array $attributes
     */
    public function update (array $attributes)
    {
        if (isset($attributes['email']))
        {
            dispatch(new ChangeUserEmail($this->user, $attributes['email'], app()->getLocale()));

            unset($attributes['email']);
        }

        if (!empty($attributes))
        {
            $this->user->update($attributes);
        }
    }

    /**
     * @param $token
     */
    public function updateEmail ($token)
    {
        $reset = \DB::table('email_resets')->where('token', $token)->first();

        $this->user->newQuery()->where('id', $reset->user_id)->update(['email' => $reset->new_email]);

        \DB::table('email_resets')->where('token', $token)->delete();
    }

    /**
     * @param $address
     */
    public function saveAddress ($address)
    {
        if (is_null($this->user->address))
        {
            $this->user->update(['address' => $address]);
        }
        if (array_diff($address, $this->user->address))
        {
            $address = array_merge($this->user->address, $address);
            $this->user->update(['address' => $address]);
        }
    }
}