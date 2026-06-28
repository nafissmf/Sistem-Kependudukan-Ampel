<?php

namespace Database\Factories;

use App\Enums\RoleCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    public function definition(): array
    {
        $code = fake()->randomElement(RoleCode::cases());

        return [
            'code' => $code,
            'name' => $code->label(),
            'description' => $code->description(),
        ];
    }
}
