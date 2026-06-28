<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Village extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = ['district_id', 'code', 'name', 'postal_code'];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function hamlets(): HasMany
    {
        return $this->hasMany(Hamlet::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
