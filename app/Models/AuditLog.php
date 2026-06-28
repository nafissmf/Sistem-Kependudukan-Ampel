<?php

namespace App\Models;

use App\Enums\AuditAction;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use HasUuids;

    public $timestamps = false; // hanya created_at, di-set manual via useCurrent() di migration

    protected $fillable = [
        'user_id', 'module', 'action', 'old_value', 'new_value',
        'browser', 'platform', 'device', 'ip_address', 'location',
    ];

    protected function casts(): array
    {
        return [
            'action' => AuditAction::class,
            'old_value' => 'array',
            'new_value' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
