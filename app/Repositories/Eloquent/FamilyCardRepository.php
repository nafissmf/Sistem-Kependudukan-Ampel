<?php

namespace App\Repositories\Eloquent;

use App\Models\FamilyCard;
use App\Repositories\Contracts\FamilyCardRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class FamilyCardRepository implements FamilyCardRepositoryInterface
{
    public function paginate(int $perPage, array $filters = []): LengthAwarePaginator
    {
        $user = Auth::user();

        return FamilyCard::query()
            ->with(['headCitizen:id,fullname', 'village:id,name'])
            ->withCount('members')
            ->when(
                $user?->role?->code?->value === 'OPERATOR_DESA' && $user->village_id,
                fn ($query) => $query->where('village_id', $user->village_id),
            )
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->where('number', 'like', "%{$search}%"))
            ->when($filters['village_id'] ?? null, fn ($query, $villageId) => $query->where('village_id', $villageId))
            ->when($filters['verification_status'] ?? null, fn ($query, $status) => $query->where('verification_status', $status))
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(string $id): ?FamilyCard
    {
        return FamilyCard::with(['headCitizen', 'house', 'village', 'hamlet', 'rtRw', 'members', 'documents'])->find($id);
    }

    public function findByNumber(string $number): ?FamilyCard
    {
        return FamilyCard::where('number', $number)->first();
    }

    public function create(array $data, array $memberIds = []): FamilyCard
    {
        $familyCard = FamilyCard::create($data);

        if (! empty($memberIds)) {
            $familyCard->members()->sync($memberIds);
        }

        return $familyCard;
    }

    public function update(FamilyCard $familyCard, array $data, ?array $memberIds = null): FamilyCard
    {
        $familyCard->update($data);

        if ($memberIds !== null) {
            $familyCard->members()->sync($memberIds);
        }

        return $familyCard;
    }

    public function softDelete(FamilyCard $familyCard): void
    {
        $familyCard->delete();
    }
}
