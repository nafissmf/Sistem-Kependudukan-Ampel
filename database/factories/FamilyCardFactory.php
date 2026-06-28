<?php

namespace Database\Factories;

use App\Enums\VerificationStatus;
use App\Models\Village;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\FamilyCard>
 */
class FamilyCardFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => fake()->unique()->numerify('33########0####1'),
            'village_id' => Village::query()->inRandomOrder()->value('id'),
            'address' => fake()->streetAddress(),
            'issued_date' => fake()->dateTimeBetween('-5 years', 'now'),
            'verification_status' => fake()->randomElement(VerificationStatus::cases()),
        ];
    }
}
