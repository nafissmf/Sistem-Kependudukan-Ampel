<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->can('user.create');
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:3', 'max:50', 'regex:/^[a-z0-9._-]+$/i', 'unique:users,username'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', Password::min(8)],
            'fullname' => ['required', 'string', 'min:3', 'max:150'],
            'phone' => ['nullable', 'regex:/^08[0-9]{8,12}$/', 'unique:users,phone'],
            'role_id' => ['required', 'uuid', 'exists:roles,id'],
            'village_id' => ['nullable', 'uuid'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.regex' => 'Username hanya boleh huruf, angka, titik, underscore, strip.',
            'phone.regex' => 'Nomor HP harus format Indonesia, contoh 081234567890.',
            'role_id.exists' => 'Role yang dipilih tidak valid.',
        ];
    }
}
