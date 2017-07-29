<?php

namespace App\Rules;


use App\GlobalSettings;

class UniqueArray
{
    public function passes($attribute, $value, $parameters)
    {
        if (isset($parameters[1])) {
            $value = strtolower($value);
        }

        $array = GlobalSettings::find($parameters[0])->data;

        return !in_array($value, $array);
    }
}