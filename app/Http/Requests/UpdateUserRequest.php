<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->can('user.update');
    }

    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'username' => ['sometimes', 'string', 'min:3', 'max:50', 'regex:/^[a-z0-9._-]+$/i', Rule::unique('users', 'username')->ignore($userId)],
            'email' => ['sometimes', 'email', 'max:150', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['sometimes', 'string', Password::min(8)],
            'fullname' => ['sometimes', 'string', 'min:3', 'max:150'],
            'phone' => ['sometimes', 'nullable', 'regex:/^08[0-9]{8,12}$/', Rule::unique('users', 'phone')->ignore($userId)],
            'role_id' => ['sometimes', 'uuid', 'exists:roles,id'],
            'village_id' => ['sometimes', 'nullable', 'uuid'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
