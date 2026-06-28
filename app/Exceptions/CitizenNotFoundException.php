<?php

namespace App\Exceptions;

use Exception;

class CitizenNotFoundException extends Exception
{
    protected $message = 'Data penduduk tidak ditemukan.';
}
