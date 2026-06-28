<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasUuids;

    protected $fillable = [
        'citizen_id', 'family_card_id', 'house_id', 'type',
        'filename', 'path', 'mime_type', 'size', 'uploaded_by',
    ];

    public function citizen(): BelongsTo
    {
        return $this->belongsTo(Citizen::class);
    }

    public function familyCard(): BelongsTo
    {
        return $this->belongsTo(FamilyCard::class);
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function url(): string
    {
        return \Illuminate\Support\Facades\Storage::disk('public')->url($this->path);
    }
}
