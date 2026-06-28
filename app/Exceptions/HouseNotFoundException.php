<?php

namespace App\Exceptions;

use Exception;

class HouseNotFoundException extends Exception
{
    protected $message = 'Data rumah tidak ditemukan.';
}
