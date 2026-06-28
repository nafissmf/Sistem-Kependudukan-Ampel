<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyMember extends Model
{
    use HasUuids;

    protected $fillable = ['family_card_id', 'citizen_id', 'relationship_id'];

    public function familyCard(): BelongsTo
    {
        return $this->belongsTo(FamilyCard::class);
    }

    public function citizen(): BelongsTo
    {
        return $this->belongsTo(Citizen::class);
    }

    public function relationship(): BelongsTo
    {
        return $this->belongsTo(FamilyRelationship::class, 'relationship_id');
    }
}
