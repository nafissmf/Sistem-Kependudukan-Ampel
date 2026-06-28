<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCitizenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->can('penduduk.create');
    }

    public function rules(): array
    {
        return [
            'nik' => ['required', 'digits:16', 'unique:citizens,nik'],
            'fullname' => ['required', 'string', 'min:3', 'max:150'],
            'birth_place' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['nullable', 'date', 'before_or_equal:today'],
            'gender' => ['required', Rule::in(['L', 'P'])],
            'religion_id' => ['nullable', 'uuid', 'exists:religions,id'],
            'education_id' => ['nullable', 'uuid', 'exists:educations,id'],
            'job_id' => ['nullable', 'uuid', 'exists:occupations,id'],
            'blood_type_id' => ['nullable', 'uuid', 'exists:blood_types,id'],
            'marital_status_id' => ['nullable', 'uuid', 'exists:marital_statuses,id'],
            'relationship_id' => ['nullable', 'uuid', 'exists:family_relationships,id'],
            'family_card_id' => ['nullable', 'uuid', 'exists:family_cards,id'],
            'phone' => ['nullable', 'regex:/^08[0-9]{8,12}$/'],
            'email' => ['nullable', 'email', 'max:150'],
            'address' => ['nullable', 'string', 'max:255'],
            'province_id' => ['nullable', 'uuid', 'exists:provinces,id'],
            'regency_id' => ['nullable', 'uuid', 'exists:regencies,id'],
            'district_id' => ['nullable', 'uuid', 'exists:districts,id'],
            'village_id' => ['nullable', 'uuid', 'exists:villages,id'],
            'hamlet_id' => ['nullable', 'uuid', 'exists:hamlets,id'],
            'rt_rw_id' => ['nullable', 'uuid', 'exists:rt_rw,id'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'documents.*' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'nik.digits' => 'NIK harus 16 digit angka.',
            'nik.unique' => 'NIK ini sudah terdaftar.',
            'phone.regex' => 'Nomor HP harus format Indonesia, contoh 081234567890.',
            'birth_date.before_or_equal' => 'Tanggal lahir tidak boleh di masa depan.',
        ];
    }
}
