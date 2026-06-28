<?php

namespace App\Models;

use App\Enums\VerificationStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Verification extends Model
{
    use HasUuids;

    protected $fillable = ['module', 'reference_id', 'validator_id', 'status', 'note', 'signature', 'verified_at'];

    protected function casts(): array
    {
        return [
            'status' => VerificationStatus::class,
            'verified_at' => 'datetime',
        ];
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validator_id');
    }
}
