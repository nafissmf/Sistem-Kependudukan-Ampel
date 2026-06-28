<?php

namespace App\Exceptions;

use Exception;

class FamilyCardNotFoundException extends Exception
{
    protected $message = 'Kartu Keluarga tidak ditemukan.';
}
