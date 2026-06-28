<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class WhatsappLog extends Model
{
    use HasUuids;

    protected $table = 'whatsapp_logs';

    public $timestamps = false;

    protected $fillable = ['phone', 'message', 'status'];

    protected function casts(): array
    {
        return ['sent_at' => 'datetime'];
    }
}
