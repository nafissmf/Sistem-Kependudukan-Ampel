<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Repository Layer
 * =======================================================
 * Aturan ketat (lihat dokumen "CLEAN ARCHITECTURE"):
 *   "Repository hanya menangani query database."
 * Tidak ada validasi, tidak ada hashing password, tidak ada audit log
 * di file ini — semua itu tugas Service Layer (lihat UserService).
 */
class UserRepository implements UserRepositoryInterface
{
    public function paginate(int $perPage, ?string $search = null, ?string $roleId = null): LengthAwarePaginator
    {
        return User::query()
            ->with('role:id,code,name')
            ->when($roleId, fn ($query) => $query->where('role_id', $roleId))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('fullname', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function findById(string $id): ?User
    {
        return User::with('role')->find($id);
    }

    public function findByUsernameOrEmail(string $identifier): ?User
    {
        return User::query()
            ->where('username', $identifier)
            ->orWhere('email', $identifier)
            ->first();
    }

    public function create(array $data): User
    {
        return User::create($data)->load('role');
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);

        return $user->load('role');
    }

    public function softDelete(User $user): void
    {
        $user->update(['is_active' => false]);
        $user->delete();
    }
}
