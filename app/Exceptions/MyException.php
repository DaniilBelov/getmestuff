<?php

namespace App\Exceptions;

class MyException extends \Exception
{
    public function __construct($message = null, $code = 0, Exception $previous = null) {
        parent::__construct();

        $this->message = getErrorMessage(...$message);
    }
}