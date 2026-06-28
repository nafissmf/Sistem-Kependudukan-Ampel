<?php

namespace Database\Factories;

use App\Enums\VerificationStatus;
use App\Models\FloorType;
use App\Models\RoofType;
use App\Models\Village;
use App\Models\WallType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\House>
 */
class HouseFactory extends Factory
{
    public function definition(): array
    {
        // Kasar di sekitar Kecamatan Ampel (lereng Merbabu), HANYA untuk
        // demo visual GIS di Phase 5 — bukan koordinat rumah sungguhan.
        $lat = -7.45 + fake()->randomFloat(6, -0.05, 0.05);
        $lng = 110.55 + fake()->randomFloat(6, -0.05, 0.05);

        return [
            'house_number' => fake()->buildingNumber(),
            'address' => fake()->streetAddress(),
            'village_id' => Village::query()->inRandomOrder()->value('id'),
            'latitude' => $lat,
            'longitude' => $lng,
            'gps_accuracy' => fake()->randomFloat(2, 3, 25),
            'land_area' => fake()->numberBetween(60, 400),
            'building_area' => fake()->numberBetween(36, 250),
            'roof_type_id' => RoofType::query()->inRandomOrder()->value('id'),
            'wall_type_id' => WallType::query()->inRandomOrder()->value('id'),
            'floor_type_id' => FloorType::query()->inRandomOrder()->value('id'),
            'bedroom_count' => fake()->numberBetween(1, 5),
            'bathroom_count' => fake()->numberBetween(1, 3),
            'verification_status' => fake()->randomElement(VerificationStatus::cases()),
        ];
    }
}
