<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Enums\VerificationStatus;
use App\Models\BloodType;
use App\Models\Education;
use App\Models\Job;
use App\Models\MaritalStatus;
use App\Models\Religion;
use App\Models\Village;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Citizen>
 */
class CitizenFactory extends Factory
{
    public function definition(): array
    {
        $gender = fake()->randomElement([Gender::Male, Gender::Female]);

        return [
            'nik' => fake()->unique()->numerify('33##############'), // diawali kode wilayah Boyolali (33xx), 16 digit
            'fullname' => $gender === Gender::Male ? fake()->firstNameMale().' '.fake()->lastName() : fake()->firstNameFemale().' '.fake()->lastName(),
            'birth_place' => fake()->randomElement(['Boyolali', 'Semarang', 'Solo', 'Salatiga']),
            'birth_date' => fake()->dateTimeBetween('-80 years', '-1 years'),
            'gender' => $gender,
            'religion_id' => Religion::query()->inRandomOrder()->value('id'),
            'education_id' => Education::query()->inRandomOrder()->value('id'),
            'job_id' => Job::query()->inRandomOrder()->value('id'),
            'blood_type_id' => BloodType::query()->inRandomOrder()->value('id'),
            'marital_status_id' => MaritalStatus::query()->inRandomOrder()->value('id'),
            'phone' => fake()->boolean(70) ? '08'.fake()->numerify('##########') : null,
            'village_id' => Village::query()->inRandomOrder()->value('id'),
            'address' => fake()->streetAddress(),
            'verification_status' => fake()->randomElement(VerificationStatus::cases()),
            'is_alive' => true,
        ];
    }
}
