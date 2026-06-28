<?php

namespace App\Exceptions;

use Exception;

class VerificationTargetNotFoundException extends Exception
{
    protected $message = 'Data yang ingin diverifikasi tidak ditemukan.';
}
