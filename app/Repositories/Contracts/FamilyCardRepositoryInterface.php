<?php

namespace App\Repositories\Contracts;

use App\Models\FamilyCard;
use Illuminate\Pagination\LengthAwarePaginator;

interface FamilyCardRepositoryInterface
{
    public function paginate(int $perPage, array $filters = []): LengthAwarePaginator;

    public function findById(string $id): ?FamilyCard;

    public function findByNumber(string $number): ?FamilyCard;

    public function create(array $data, array $memberIds = []): FamilyCard;

    public function update(FamilyCard $familyCard, array $data, ?array $memberIds = null): FamilyCard;

    public function softDelete(FamilyCard $familyCard): void;
}
