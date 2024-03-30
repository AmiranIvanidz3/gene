<?php

namespace App\Exceptions;

use Exception;

class ErrorPageException extends Exception
{
    public function __construct($code)
    {
        $this->message = $code;
    }
}