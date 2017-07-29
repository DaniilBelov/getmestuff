<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['ip_address', 'country', 'country_code', 'remember_key', 'user_id'];

    public function setCountry()
    {
        if (!$this->checkIfCookieExists()) {
            $ip = request()->ip();
//            $ip = request()->server('HTTP_X_FORWARDED_FOR');

            $data = ip_info($ip);

            $country = $data['country'];
            $country_code = $data['country_code'];
            $remember_key = str_random();

            $this->createCountry($ip, $country, $country_code, $remember_key);
        }
    }

    protected function checkIfCookieExists()
    {
        return !is_null(request()->cookie('visited'));
    }

    public static function updateCountry($id)
    {
        $remember_key = request()->cookie('visited');

        if(!is_null($remember_key)) {
            $set = static::query()->getByKey($remember_key)->first();
            $set->user_id = $id;

            $set->save();
        } else {
            $set = static::query()->getByIp()->first();
            if (!is_null($set)) {
                $set->user_id = $id;

                \Cookie::queue('visited', $set->remember_id, 2628000);

                $set->save();
            }
        }
    }

    public function scopeGetByKey($query, $key)
    {
        return $query->where('remember_key', $key);
    }

    public function scopeGetByIp($query)
    {
        return $query->where('ip_address', request()->ip());
    }

    protected function createCountry($ip, $country, $country_code, $remember_key)
    {
        $data = $this->newQuery()->getByIp()->first();

        if (is_null($data)) {
            $this->create([
                'ip_address' => $ip,
                'country' => $country,
                'country_code' => $country_code,
                'remember_key' => $remember_key
            ]);

            \Cookie::queue('visited', $remember_key, 2628000);
        } else {
            $key = $data->remember_key;

            \Cookie::queue('visited', $key, 2628000);
        }
    }

    public function getVisits()
    {
        $countries = $this->newQuery()->select('country', 'user_id', 'country_code')
            ->orderBy('country')->get();

        list($visitors, $visitorCountryName, $visitorCountryCode) = $this->getCountries($countries, 'visitor');
        list($users, $userCountryName, $userCountryCode) = $this->getCountries($countries, 'user');
        list($total, $countryNames, $countryCodes) = $this->getCountries($countries);

        $nameList['users'] = $userCountryName->map(function ($item) use ($users) {
            return ['count' => $item, 'total' => $users];
        });
        $nameList['visitors'] = $visitorCountryName->map(function ($item) use ($visitors) {
            return ['count' => $item, 'total' => $visitors];
        });;

        $codeList['users'] = $userCountryCode;
        $codeList['visitors'] = $visitorCountryCode;


        return [
            'visits' => $nameList,
            'map_info' => $codeList,
            'map_data' => $countryCodes
        ];
    }

    protected function getCountries($countries, $group = false)
    {
        if ($group) {
            $countries = $countries->filter(function ($item) use ($group) {
                if ($group == 'user') return !is_null($item->user_id);
                return is_null($item->user_id);
            });
        }

        $total = $countries->count();

        $countryNames = $countries->groupBy(function ($item) {
            return $item->country;
        })->map(function ($item) {
            return $item->count();
        });

        $countryCodes = $countries->groupBy(function ($item) {
            return $item->country_code;
        })->map(function ($item) {
            return $item->count();
        });

        return [$total, $countryNames, $countryCodes];
    }
}
