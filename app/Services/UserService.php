<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Exceptions\DuplicateUserException;
use App\Exceptions\UserNotFoundException;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

/**
 * Service Layer
 * =======================================================
 * Aturan ketat (lihat dokumen "CLEAN ARCHITECTURE"):
 *   "Semua business logic berada di Service."
 * Controller hanya memanggil fungsi di sini dan meneruskan hasilnya —
 * tidak ada query Eloquent langsung di Controller.
 */
class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
        private readonly AuditService $audit,
    ) {}

    public function list(int $page, int $perPage, ?string $search, ?string $roleId): LengthAwarePaginator
    {
        return $this->users->paginate($perPage, $search, $roleId);
    }

    public function find(string $id): User
    {
        $user = $this->users->findById($id);

        if (! $user) {
            throw new UserNotFoundException;
        }

        return $user;
    }

    public function create(array $input, string $actorUserId, ?Request $request = null): User
    {
        if ($this->users->findByUsernameOrEmail($input['username'])
            || $this->users->findByUsernameOrEmail($input['email'])) {
            throw new DuplicateUserException;
        }

        $created = $this->users->create([
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'fullname' => $input['fullname'],
            'phone' => $input['phone'] ?? null,
            'role_id' => $input['role_id'],
            'village_id' => $input['village_id'] ?? null,
            'created_by' => $actorUserId,
        ]);

        $this->audit->record(
            userId: $actorUserId,
            module: 'user',
            action: AuditAction::Create,
            newValue: $created->toArray(),
            request: $request,
        );

        return $created;
    }

    public function update(string $id, array $input, string $actorUserId, ?Request $request = null): User
    {
        $user = $this->users->findById($id);

        if (! $user) {
            throw new UserNotFoundException;
        }

        $before = $user->toArray();

        $payload = array_filter([
            'fullname' => $input['fullname'] ?? null,
            'email' => $input['email'] ?? null,
            'phone' => $input['phone'] ?? null,
            'role_id' => $input['role_id'] ?? null,
            'is_active' => $input['is_active'] ?? null,
        ], fn ($value) => $value !== null);

        if (! empty($input['password'])) {
            $payload['password'] = Hash::make($input['password']);
        }

        $payload['updated_by'] = $actorUserId;

        $updated = $this->users->update($user, $payload);

        $this->audit->record(
            userId: $actorUserId,
            module: 'user',
            action: AuditAction::Update,
            oldValue: $before,
            newValue: $updated->toArray(),
            request: $request,
        );

        return $updated;
    }

    public function delete(string $id, string $actorUserId, ?Request $request = null): void
    {
        $user = $this->users->findById($id);

        if (! $user) {
            throw new UserNotFoundException;
        }

        $before = $user->toArray();

        $this->users->softDelete($user);

        $this->audit->record(
            userId: $actorUserId,
            module: 'user',
            action: AuditAction::Delete,
            oldValue: $before,
            request: $request,
        );
    }
}
