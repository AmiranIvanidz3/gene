<?php

namespace App\Exceptions;

use Exception;

class SuccessException extends Exception
{
    protected $message = 'success';
}