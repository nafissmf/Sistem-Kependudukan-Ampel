<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Enums\VerificationStatus;
use App\Exceptions\CitizenNotFoundException;
use App\Exceptions\DuplicateNikException;
use App\Models\Citizen;
use App\Repositories\Contracts\CitizenRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class CitizenService
{
    public function __construct(
        private readonly CitizenRepositoryInterface $citizens,
        private readonly AuditService $audit,
    ) {}

    public function list(int $perPage, array $filters): LengthAwarePaginator
    {
        return $this->citizens->paginate($perPage, $filters);
    }

    public function find(string $id): Citizen
    {
        $citizen = $this->citizens->findById($id);

        if (! $citizen) {
            throw new CitizenNotFoundException;
        }

        return $citizen;
    }

    public function create(array $input, string $actorUserId, ?Request $request = null): Citizen
    {
        if ($this->citizens->findByNik($input['nik'])) {
            throw new DuplicateNikException;
        }

        $photoPath = $this->storePhotoIfPresent($input['photo'] ?? null);

        $created = $this->citizens->create([
            ...array_diff_key($input, array_flip(['photo', 'documents'])),
            'photo' => $photoPath,
            'verification_status' => VerificationStatus::Pending,
            'created_by' => $actorUserId,
        ]);

        $this->storeDocumentsIfPresent($created, $input['documents'] ?? [], $actorUserId);

        $this->audit->record(
            userId: $actorUserId,
            module: 'penduduk',
            action: AuditAction::Create,
            newValue: $created->toArray(),
            request: $request,
        );

        return $created;
    }

    public function update(string $id, array $input, string $actorUserId, ?Request $request = null): Citizen
    {
        $citizen = $this->citizens->findById($id);

        if (! $citizen) {
            throw new CitizenNotFoundException;
        }

        $before = $citizen->toArray();

        $payload = array_diff_key($input, array_flip(['photo', 'documents']));

        if (! empty($input['photo']) && $input['photo'] instanceof UploadedFile) {
            $payload['photo'] = $this->storePhotoIfPresent($input['photo'], $citizen->photo);
        }

        // Setiap kali data diedit, kembalikan ke status Pending supaya
        // divalidasi ulang oleh Validator Desa (sesuai dokumen "OPERATOR
        // DESA": "Mengedit data sebelum diverifikasi").
        $payload['verification_status'] = VerificationStatus::Pending;
        $payload['updated_by'] = $actorUserId;

        $updated = $this->citizens->update($citizen, $payload);

        $this->audit->record(
            userId: $actorUserId,
            module: 'penduduk',
            action: AuditAction::Update,
            oldValue: $before,
            newValue: $updated->toArray(),
            request: $request,
        );

        return $updated;
    }

    public function delete(string $id, string $actorUserId, ?Request $request = null): void
    {
        $citizen = $this->citizens->findById($id);

        if (! $citizen) {
            throw new CitizenNotFoundException;
        }

        $before = $citizen->toArray();

        $this->citizens->softDelete($citizen);

        $this->audit->record(
            userId: $actorUserId,
            module: 'penduduk',
            action: AuditAction::Delete,
            oldValue: $before,
            request: $request,
        );
    }

    /** @return array<string, int> Jumlah penduduk per status verifikasi, dipakai widget dashboard. */
    public function statusSummary(): array
    {
        return $this->citizens->countByStatus();
    }

    private function storePhotoIfPresent(?UploadedFile $photo, ?string $previousPath = null): ?string
    {
        if (! $photo) {
            return $previousPath;
        }

        if ($previousPath) {
            Storage::disk('public')->delete($previousPath);
        }

        return $photo->store('citizens/photos', 'public');
    }

    /** @param  UploadedFile[]  $documents */
    private function storeDocumentsIfPresent(Citizen $citizen, array $documents, string $actorUserId): void
    {
        foreach ($documents as $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $path = $file->store('citizens/documents', 'public');

            $citizen->documents()->create([
                'type' => 'LAINNYA',
                'filename' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
                'uploaded_by' => $actorUserId,
            ]);
        }
    }
}
