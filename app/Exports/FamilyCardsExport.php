<?php

namespace App\Exports;

use App\Models\FamilyCard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FamilyCardsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private readonly ?array $filters = []) {}

    public function collection()
    {
        return FamilyCard::query()
            ->with(['headCitizen', 'village'])
            ->withCount('members')
            ->when($this->filters['village_id'] ?? null, fn ($q, $v) => $q->where('village_id', $v))
            ->orderBy('number')
            ->get();
    }

    public function headings(): array
    {
        return ['Nomor KK', 'Kepala Keluarga', 'Desa', 'Jumlah Anggota', 'Status'];
    }

    public function map($familyCard): array
    {
        return [
            $familyCard->number,
            $familyCard->headCitizen?->fullname,
            $familyCard->village?->name,
            $familyCard->members_count,
            $familyCard->verification_status->label(),
        ];
    }
}
