<?php

namespace App\Exceptions;

use Exception;

class DuplicateNikException extends Exception
{
    protected $message = 'NIK ini sudah terdaftar untuk penduduk lain.';
}
