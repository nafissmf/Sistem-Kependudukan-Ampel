<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VerificationDecisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        $action = match ($this->input('decision')) {
            'APPROVED' => 'verifikasi.approve',
            'REJECTED' => 'verifikasi.reject',
            'REVISION' => 'verifikasi.reject', // revisi memakai permission yang sama dengan reject
            default => null,
        };

        return $action ? (bool) $this->user()?->can($action) : false;
    }

    public function rules(): array
    {
        return [
            'decision' => ['required', Rule::in(['APPROVED', 'REJECTED', 'REVISION'])],
            'note' => ['nullable', 'string', 'max:1000', 'required_unless:decision,APPROVED'],
            'signature' => ['nullable', 'string'], // data URL base64 dari <canvas>, wajib untuk APPROVED (dicek di controller)
        ];
    }

    public function messages(): array
    {
        return [
            'note.required_unless' => 'Catatan wajib diisi untuk Reject/Revisi.',
        ];
    }
}
