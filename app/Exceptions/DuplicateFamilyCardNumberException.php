<?php

namespace App\Exceptions;

use Exception;

class DuplicateFamilyCardNumberException extends Exception
{
    protected $message = 'Nomor KK ini sudah terdaftar.';
}
