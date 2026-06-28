<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Enums\VerificationStatus;
use App\Exceptions\HouseNotFoundException;
use App\Models\House;
use App\Repositories\Contracts\HouseRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class HouseService
{
    public function __construct(
        private readonly HouseRepositoryInterface $houses,
        private readonly AuditService $audit,
    ) {}

    public function list(int $perPage, array $filters): LengthAwarePaginator
    {
        return $this->houses->paginate($perPage, $filters);
    }

    public function find(string $id): House
    {
        $house = $this->houses->findById($id);

        if (! $house) {
            throw new HouseNotFoundException;
        }

        return $house;
    }

    public function create(array $input, string $actorUserId, ?Request $request = null): House
    {
        $photoPath = $this->storePhotoIfPresent($input['photo'] ?? null);

        $created = $this->houses->create([
            ...array_diff_key($input, array_flip(['photo'])),
            'photo' => $photoPath,
            'verification_status' => VerificationStatus::Pending,
            'created_by' => $actorUserId,
        ]);

        $this->audit->record(
            userId: $actorUserId,
            module: 'rumah',
            action: AuditAction::Create,
            newValue: $created->toArray(),
            request: $request,
        );

        return $created;
    }

    public function update(string $id, array $input, string $actorUserId, ?Request $request = null): House
    {
        $house = $this->houses->findById($id);

        if (! $house) {
            throw new HouseNotFoundException;
        }

        $before = $house->toArray();
        $payload = array_diff_key($input, array_flip(['photo']));

        if (! empty($input['photo']) && $input['photo'] instanceof UploadedFile) {
            $payload['photo'] = $this->storePhotoIfPresent($input['photo'], $house->photo);
        }

        $payload['verification_status'] = VerificationStatus::Pending;
        $payload['updated_by'] = $actorUserId;

        $updated = $this->houses->update($house, $payload);

        $this->audit->record(
            userId: $actorUserId,
            module: 'rumah',
            action: AuditAction::Update,
            oldValue: $before,
            newValue: $updated->toArray(),
            request: $request,
        );

        return $updated;
    }

    public function delete(string $id, string $actorUserId, ?Request $request = null): void
    {
        $house = $this->houses->findById($id);

        if (! $house) {
            throw new HouseNotFoundException;
        }

        $before = $house->toArray();
        $this->houses->softDelete($house);

        $this->audit->record(
            userId: $actorUserId,
            module: 'rumah',
            action: AuditAction::Delete,
            oldValue: $before,
            request: $request,
        );
    }

    private function storePhotoIfPresent(?UploadedFile $photo, ?string $previousPath = null): ?string
    {
        if (! $photo) {
            return $previousPath;
        }

        if ($previousPath) {
            Storage::disk('public')->delete($previousPath);
        }

        return $photo->store('houses/photos', 'public');
    }
}
