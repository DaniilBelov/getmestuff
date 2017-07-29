<?php

namespace App\Rules;


class AlphaNumS
{
    public function passes($attribute, $value)
    {
        return preg_match('/^[\pL\s\d]+$/u', $value);
    }
}