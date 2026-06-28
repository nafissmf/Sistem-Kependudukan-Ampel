<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = ['recipient', 'subject', 'status'];

    protected function casts(): array
    {
        return ['sent_at' => 'datetime'];
    }
}
