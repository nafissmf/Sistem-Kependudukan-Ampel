<?php

namespace App\Repositories\Contracts;

use App\Models\House;
use Illuminate\Pagination\LengthAwarePaginator;

interface HouseRepositoryInterface
{
    public function paginate(int $perPage, array $filters = []): LengthAwarePaginator;

    public function findById(string $id): ?House;

    public function create(array $data): House;

    public function update(House $house, array $data): House;

    public function softDelete(House $house): void;

    /** Semua rumah yang punya koordinat valid, untuk GIS (Phase 5). */
    public function allWithCoordinates(): \Illuminate\Support\Collection;
}
