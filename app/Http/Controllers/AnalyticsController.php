<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\Education;
use App\Models\Job;
use App\Models\Religion;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('analytics.read'), 403);

        return view('analytics.index', [
            'genderChart' => $this->genderDistribution(),
            'religionChart' => $this->countByReference(Religion::class, 'religion_id'),
            'educationChart' => $this->countByReference(Education::class, 'education_id'),
            'jobChart' => $this->countByReference(Job::class, 'job_id'),
            'ageGroupChart' => $this->ageGroupDistribution(),
            'totalCitizens' => Citizen::count(),
        ]);
    }

    private function genderDistribution(): array
    {
        $rows = Citizen::query()->select('gender', DB::raw('count(*) as total'))->groupBy('gender')->pluck('total', 'gender');

        return [
            'labels' => ['Laki-laki', 'Perempuan'],
            'data' => [$rows->get('L', 0), $rows->get('P', 0)],
        ];
    }

    /** @param  class-string<\App\Models\ReferenceModel>  $referenceModel */
    private function countByReference(string $referenceModel, string $foreignKey): array
    {
        $rows = Citizen::query()
            ->select($foreignKey, DB::raw('count(*) as total'))
            ->groupBy($foreignKey)
            ->pluck('total', $foreignKey);

        $references = $referenceModel::all();

        return [
            'labels' => $references->pluck('name')->all(),
            'data' => $references->map(fn ($ref) => $rows->get($ref->id, 0))->all(),
        ];
    }

    private function ageGroupDistribution(): array
    {
        $groups = [
            'Balita (0-4)' => [0, 4],
            'Anak (5-12)' => [5, 12],
            'Remaja (13-17)' => [13, 17],
            'Produktif (18-59)' => [18, 59],
            'Lansia (60+)' => [60, 200],
        ];

        $data = [];
        foreach ($groups as $label => [$min, $max]) {
            $data[] = Citizen::query()
                ->whereNotNull('birth_date')
                ->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN ? AND ?', [$min, $max])
                ->count();
        }

        return ['labels' => array_keys($groups), 'data' => $data];
    }
}
