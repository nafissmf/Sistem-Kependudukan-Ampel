<?php

namespace App\Models;

use App\Enums\VerificationStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyCard extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'number', 'head_citizen_id', 'house_id', 'address', 'postal_code',
        'province_id', 'regency_id', 'district_id', 'village_id', 'hamlet_id', 'rt_rw_id',
        'qr_code', 'barcode', 'verification_status', 'issued_date',
        'created_by', 'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'verification_status' => VerificationStatus::class,
            'issued_date' => 'date',
        ];
    }

    public function headCitizen(): BelongsTo
    {
        return $this->belongsTo(Citizen::class, 'head_citizen_id');
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function hamlet(): BelongsTo
    {
        return $this->belongsTo(Hamlet::class);
    }

    public function rtRw(): BelongsTo
    {
        return $this->belongsTo(RtRw::class, 'rt_rw_id');
    }

    /** Anggota keluarga lewat tabel pivot family_members. */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Citizen::class, 'family_members')
            ->withPivot('relationship_id')
            ->withTimestamps();
    }

    /** Semua citizen yang field family_card_id-nya menunjuk ke KK ini (relasi langsung/denormalized). */
    public function citizens(): HasMany
    {
        return $this->hasMany(Citizen::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
