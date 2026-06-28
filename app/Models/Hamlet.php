<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hamlet extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = ['village_id', 'name'];

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function rtRws(): HasMany
    {
        return $this->hasMany(RtRw::class);
    }
}
