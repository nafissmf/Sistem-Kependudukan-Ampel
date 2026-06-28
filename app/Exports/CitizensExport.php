<?php

namespace App\Exports;

use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CitizensExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private readonly ?array $filters = []) {}

    public function collection()
    {
        return Citizen::query()
            ->with(['village'])
            ->when($this->filters['village_id'] ?? null, fn ($q, $v) => $q->where('village_id', $v))
            ->when($this->filters['verification_status'] ?? null, fn ($q, $v) => $q->where('verification_status', $v))
            ->orderBy('fullname')
            ->get();
    }

    public function headings(): array
    {
        return ['NIK', 'Nama', 'Jenis Kelamin', 'Tanggal Lahir', 'Umur', 'Desa', 'Alamat', 'Status Verifikasi'];
    }

    public function map($citizen): array
    {
        return [
            $citizen->nik,
            $citizen->fullname,
            $citizen->gender->label(),
            $citizen->birth_date?->format('d-m-Y'),
            $citizen->age,
            $citizen->village?->name,
            $citizen->address,
            $citizen->verification_status->label(),
        ];
    }
}
