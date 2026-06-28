<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    use HasUuids;

    protected $fillable = ['code', 'name'];

    public function regencies(): HasMany
    {
        return $this->hasMany(Regency::class);
    }
}
