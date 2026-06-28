<?php

namespace App\Exports;

use App\Models\House;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HousesExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private readonly ?array $filters = []) {}

    public function collection()
    {
        return House::query()
            ->with(['village'])
            ->when($this->filters['village_id'] ?? null, fn ($q, $v) => $q->where('village_id', $v))
            ->orderBy('house_number')
            ->get();
    }

    public function headings(): array
    {
        return ['Nomor Rumah', 'Alamat', 'Desa', 'Latitude', 'Longitude', 'Status'];
    }

    public function map($house): array
    {
        return [
            $house->house_number,
            $house->address,
            $house->village?->name,
            $house->latitude,
            $house->longitude,
            $house->verification_status->label(),
        ];
    }
}
