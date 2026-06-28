<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\VerificationStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Citizen extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'nik', 'fullname', 'birth_place', 'birth_date', 'gender',
        'religion_id', 'education_id', 'job_id', 'blood_type_id', 'marital_status_id',
        'family_card_id', 'relationship_id',
        'phone', 'email', 'photo', 'latitude', 'longitude', 'address',
        'province_id', 'regency_id', 'district_id', 'village_id', 'hamlet_id', 'rt_rw_id',
        'citizen_status_id', 'verification_status', 'is_alive', 'death_date',
        'created_by', 'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'gender' => Gender::class,
            'verification_status' => VerificationStatus::class,
            'birth_date' => 'date',
            'death_date' => 'date',
            'is_alive' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function getAgeAttribute(): ?int
    {
        return $this->birth_date?->age;
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class);
    }

    public function education(): BelongsTo
    {
        return $this->belongsTo(Education::class);
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function bloodType(): BelongsTo
    {
        return $this->belongsTo(BloodType::class);
    }

    public function maritalStatus(): BelongsTo
    {
        return $this->belongsTo(MaritalStatus::class);
    }

    public function relationship(): BelongsTo
    {
        return $this->belongsTo(FamilyRelationship::class, 'relationship_id');
    }

    public function familyCard(): BelongsTo
    {
        return $this->belongsTo(FamilyCard::class);
    }

    public function citizenStatus(): BelongsTo
    {
        return $this->belongsTo(CitizenStatus::class);
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

    /** KK lain tempat citizen ini tercatat sebagai anggota (lewat pivot). */
    public function familyCards(): BelongsToMany
    {
        return $this->belongsToMany(FamilyCard::class, 'family_members')
            ->withPivot('relationship_id')
            ->withTimestamps();
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function headOfFamilyCards(): HasMany
    {
        return $this->hasMany(FamilyCard::class, 'head_citizen_id');
    }
}
