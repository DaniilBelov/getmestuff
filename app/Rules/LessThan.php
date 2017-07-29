<?php

namespace App\Rules;

class LessThan
{
    public function passes($attribute, $value, $params, $validator)
    {
        $param = $validator->getData()[$params[0]];

        $validator->addReplacer('less_than', function($message, $attribute, $rule, $parameters){
            $parameters = preg_replace('/_/', ' ', $parameters);
            return str_replace([':param'], $parameters, $message);
        });

        if ($param < $value) return false;

        return true;
    }
}