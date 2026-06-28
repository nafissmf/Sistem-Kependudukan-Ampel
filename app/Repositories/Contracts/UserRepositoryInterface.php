<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Kontrak Repository — Service layer bergantung pada interface ini, bukan
 * implementasi Eloquent secara langsung. Memudahkan ganti sumber data
 * (mis. ke API eksternal / cache layer) tanpa mengubah Service.
 */
interface UserRepositoryInterface
{
    public function paginate(int $perPage, ?string $search = null, ?string $roleId = null): LengthAwarePaginator;

    public function findById(string $id): ?User;

    public function findByUsernameOrEmail(string $identifier): ?User;

    public function create(array $data): User;

    public function update(User $user, array $data): User;

    public function softDelete(User $user): void;
}
