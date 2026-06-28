<?php

namespace App\Models;

use App\Enums\VerificationStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class House extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'house_number', 'latitude', 'longitude', 'gps_accuracy', 'address',
        'province_id', 'regency_id', 'district_id', 'village_id', 'hamlet_id', 'rt_rw_id',
        'land_area', 'building_area', 'roof_type_id', 'wall_type_id', 'floor_type_id',
        'bedroom_count', 'bathroom_count', 'photo', 'google_map_url',
        'house_status_id', 'verification_status', 'qr_code', 'barcode',
        'created_by', 'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'verification_status' => VerificationStatus::class,
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
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

    public function roofType(): BelongsTo
    {
        return $this->belongsTo(RoofType::class);
    }

    public function wallType(): BelongsTo
    {
        return $this->belongsTo(WallType::class);
    }

    public function floorType(): BelongsTo
    {
        return $this->belongsTo(FloorType::class);
    }

    public function houseStatus(): BelongsTo
    {
        return $this->belongsTo(HouseStatus::class);
    }

    public function familyCard(): HasOne
    {
        return $this->hasOne(FamilyCard::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
