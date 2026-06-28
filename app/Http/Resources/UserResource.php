<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'fullname' => $this->fullname,
            'phone' => $this->phone,
            'photo' => $this->photo,
            'is_active' => $this->is_active,
            'last_login' => $this->last_login?->toIso8601String(),
            'role' => $this->whenLoaded('role', fn () => [
                'id' => $this->role->id,
                'code' => $this->role->code->value,
                'name' => $this->role->name,
            ]),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
