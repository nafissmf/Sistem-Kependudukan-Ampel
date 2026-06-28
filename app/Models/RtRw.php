<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RtRw extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'rt_rw';

    protected $fillable = ['hamlet_id', 'rt', 'rw'];

    public function hamlet(): BelongsTo
    {
        return $this->belongsTo(Hamlet::class);
    }

    public function label(): string
    {
        return "RT {$this->rt}/RW {$this->rw}";
    }
}
