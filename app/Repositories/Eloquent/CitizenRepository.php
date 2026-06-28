<?php

namespace App\Repositories\Eloquent;

use App\Models\Citizen;
use App\Repositories\Contracts\CitizenRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

/**
 * Repository Layer — hanya query database, tidak ada business logic
 * (lihat penjelasan pola ini di app/Repositories/Eloquent/UserRepository.php).
 */
class CitizenRepository implements CitizenRepositoryInterface
{
    public function paginate(int $perPage, array $filters = []): LengthAwarePaginator
    {
        $user = Auth::user();

        return Citizen::query()
            ->with(['village:id,name', 'religion:id,name', 'citizenStatus:id,name'])
            // Operator Desa hanya melihat penduduk di desanya sendiri
            // (scoping desa ditegakkan di sini, bukan di RBAC matrix —
            // RBAC hanya soal modul+aksi, scoping data adalah hal lain).
            ->when(
                $user?->role?->code?->value === 'OPERATOR_DESA' && $user->village_id,
                fn ($query) => $query->where('village_id', $user->village_id),
            )
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('fullname', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                });
            })
            ->when($filters['village_id'] ?? null, fn ($query, $villageId) => $query->where('village_id', $villageId))
            ->when($filters['verification_status'] ?? null, fn ($query, $status) => $query->where('verification_status', $status))
            ->when($filters['gender'] ?? null, fn ($query, $gender) => $query->where('gender', $gender))
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(string $id): ?Citizen
    {
        return Citizen::with([
            'religion', 'education', 'job', 'bloodType', 'maritalStatus', 'relationship',
            'familyCard', 'village', 'hamlet', 'rtRw', 'citizenStatus', 'documents',
        ])->find($id);
    }

    public function findByNik(string $nik): ?Citizen
    {
        return Citizen::where('nik', $nik)->first();
    }

    public function create(array $data): Citizen
    {
        return Citizen::create($data);
    }

    public function update(Citizen $citizen, array $data): Citizen
    {
        $citizen->update($data);

        return $citizen;
    }

    public function softDelete(Citizen $citizen): void
    {
        $citizen->delete();
    }

    public function countByStatus(): array
    {
        return Citizen::query()
            ->selectRaw('verification_status, count(*) as total')
            ->groupBy('verification_status')
            ->pluck('total', 'verification_status')
            ->toArray();
    }
}
