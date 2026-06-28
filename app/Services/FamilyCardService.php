<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Enums\VerificationStatus;
use App\Exceptions\DuplicateFamilyCardNumberException;
use App\Exceptions\FamilyCardNotFoundException;
use App\Models\FamilyCard;
use App\Repositories\Contracts\FamilyCardRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class FamilyCardService
{
    public function __construct(
        private readonly FamilyCardRepositoryInterface $familyCards,
        private readonly AuditService $audit,
    ) {}

    public function list(int $perPage, array $filters): LengthAwarePaginator
    {
        return $this->familyCards->paginate($perPage, $filters);
    }

    public function find(string $id): FamilyCard
    {
        $familyCard = $this->familyCards->findById($id);

        if (! $familyCard) {
            throw new FamilyCardNotFoundException;
        }

        return $familyCard;
    }

    public function create(array $input, string $actorUserId, ?Request $request = null): FamilyCard
    {
        if ($this->familyCards->findByNumber($input['number'])) {
            throw new DuplicateFamilyCardNumberException;
        }

        $memberIds = $input['member_ids'] ?? [];

        $created = $this->familyCards->create([
            ...array_diff_key($input, array_flip(['member_ids'])),
            'verification_status' => VerificationStatus::Pending,
            'created_by' => $actorUserId,
        ], $memberIds);

        $this->audit->record(
            userId: $actorUserId,
            module: 'kk',
            action: AuditAction::Create,
            newValue: $created->toArray(),
            request: $request,
        );

        return $created;
    }

    public function update(string $id, array $input, string $actorUserId, ?Request $request = null): FamilyCard
    {
        $familyCard = $this->familyCards->findById($id);

        if (! $familyCard) {
            throw new FamilyCardNotFoundException;
        }

        $before = $familyCard->toArray();
        $memberIds = $input['member_ids'] ?? null;

        $payload = array_diff_key($input, array_flip(['member_ids']));
        $payload['verification_status'] = VerificationStatus::Pending;
        $payload['updated_by'] = $actorUserId;

        $updated = $this->familyCards->update($familyCard, $payload, $memberIds);

        $this->audit->record(
            userId: $actorUserId,
            module: 'kk',
            action: AuditAction::Update,
            oldValue: $before,
            newValue: $updated->toArray(),
            request: $request,
        );

        return $updated;
    }

    public function delete(string $id, string $actorUserId, ?Request $request = null): void
    {
        $familyCard = $this->familyCards->findById($id);

        if (! $familyCard) {
            throw new FamilyCardNotFoundException;
        }

        $before = $familyCard->toArray();
        $this->familyCards->softDelete($familyCard);

        $this->audit->record(
            userId: $actorUserId,
            module: 'kk',
            action: AuditAction::Delete,
            oldValue: $before,
            request: $request,
        );
    }
}
