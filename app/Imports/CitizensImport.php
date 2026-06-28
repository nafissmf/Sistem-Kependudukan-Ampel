<?php

namespace App\Imports;

use App\Enums\VerificationStatus;
use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

/**
 * Import Excel Penduduk (Phase 6).
 *
 * Format kolom yang diharapkan (heading row, urutan bebas):
 *   nik | fullname | gender | birth_place | birth_date | phone | address
 *
 * Baris yang gagal validasi DILEWATI (tidak menghentikan seluruh proses),
 * dan dicatat lewat SkipsOnFailure — sesuai brief "Import Data: Validation,
 * Duplicate Detection" (duplikat NIK otomatis tertangkap oleh rule unique).
 */
class CitizensImport implements SkipsOnFailure, ToModel, WithHeadingRow, WithValidation
{
    use Importable, SkipsFailures;

    public function model(array $row): Citizen
    {
        return new Citizen([
            'nik' => (string) $row['nik'],
            'fullname' => $row['fullname'],
            'gender' => strtoupper($row['gender']) === 'P' ? 'P' : 'L',
            'birth_place' => $row['birth_place'] ?? null,
            'birth_date' => ! empty($row['birth_date']) ? $row['birth_date'] : null,
            'phone' => $row['phone'] ?? null,
            'address' => $row['address'] ?? null,
            'verification_status' => VerificationStatus::Pending,
        ]);
    }

    public function rules(): array
    {
        return [
            'nik' => ['required', 'digits:16', 'unique:citizens,nik'],
            'fullname' => ['required', 'string', 'min:3'],
            'gender' => ['required'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nik.digits' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar (duplikat).',
        ];
    }
}
