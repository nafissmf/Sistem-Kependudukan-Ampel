<?php

namespace App\Exceptions;

use Exception;

class DuplicateUserException extends Exception
{
    protected $message = 'Username, email, atau nomor HP sudah digunakan.';
}
