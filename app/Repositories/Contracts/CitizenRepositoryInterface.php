<?php

namespace App\Repositories\Contracts;

use App\Models\Citizen;
use Illuminate\Pagination\LengthAwarePaginator;

interface CitizenRepositoryInterface
{
    public function paginate(int $perPage, array $filters = []): LengthAwarePaginator;

    public function findById(string $id): ?Citizen;

    public function findByNik(string $nik): ?Citizen;

    public function create(array $data): Citizen;

    public function update(Citizen $citizen, array $data): Citizen;

    public function softDelete(Citizen $citizen): void;

    public function countByStatus(): array;
}
