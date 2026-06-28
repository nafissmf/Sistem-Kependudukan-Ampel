<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyCardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->can('kk.create');
    }

    public function rules(): array
    {
        return [
            'number' => ['required', 'digits:16', 'unique:family_cards,number'],
            'head_citizen_id' => ['nullable', 'uuid', 'exists:citizens,id'],
            'house_id' => ['nullable', 'uuid', 'exists:houses,id'],
            'address' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'village_id' => ['nullable', 'uuid', 'exists:villages,id'],
            'hamlet_id' => ['nullable', 'uuid', 'exists:hamlets,id'],
            'rt_rw_id' => ['nullable', 'uuid', 'exists:rt_rw,id'],
            'issued_date' => ['nullable', 'date'],
            'member_ids' => ['nullable', 'array'],
            'member_ids.*' => ['uuid', 'exists:citizens,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'number.digits' => 'Nomor KK harus 16 digit angka.',
            'number.unique' => 'Nomor KK ini sudah terdaftar.',
        ];
    }
}
