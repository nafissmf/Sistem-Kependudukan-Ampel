<?php

namespace App\Repositories\Eloquent;

use App\Models\House;
use App\Repositories\Contracts\HouseRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class HouseRepository implements HouseRepositoryInterface
{
    public function paginate(int $perPage, array $filters = []): LengthAwarePaginator
    {
        $user = Auth::user();

        return House::query()
            ->with(['village:id,name'])
            ->when(
                $user?->role?->code?->value === 'OPERATOR_DESA' && $user->village_id,
                fn ($query) => $query->where('village_id', $user->village_id),
            )
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('house_number', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                });
            })
            ->when($filters['village_id'] ?? null, fn ($query, $villageId) => $query->where('village_id', $villageId))
            ->when($filters['verification_status'] ?? null, fn ($query, $status) => $query->where('verification_status', $status))
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(string $id): ?House
    {
        return House::with(['village', 'hamlet', 'rtRw', 'roofType', 'wallType', 'floorType', 'houseStatus', 'familyCard', 'documents'])->find($id);
    }

    public function create(array $data): House
    {
        return House::create($data);
    }

    public function update(House $house, array $data): House
    {
        $house->update($data);

        return $house;
    }

    public function softDelete(House $house): void
    {
        $house->delete();
    }

    public function allWithCoordinates(): Collection
    {
        return House::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'house_number', 'latitude', 'longitude', 'verification_status']);
    }
}
