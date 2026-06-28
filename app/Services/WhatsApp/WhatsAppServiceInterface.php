<?php

namespace App\Services\WhatsApp;

interface WhatsAppServiceInterface
{
    public function send(string $phone, string $message): bool;
}
