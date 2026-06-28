<?php

namespace App\Http\Controllers;

use App\Enums\VerificationStatus;
use App\Models\AuditLog;
use App\Models\Citizen;
use App\Models\FamilyCard;
use App\Models\House;
use App\Support\Rbac;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $role = $user->role->code;

        $hour = (int) now()->format('G');
        $greeting = match (true) {
            $hour < 11 => 'Selamat pagi',
            $hour < 15 => 'Selamat siang',
            $hour < 18 => 'Selamat sore',
            default => 'Selamat malam',
        };

        $canPenduduk = Rbac::canAccessModule($role, 'penduduk');
        $canKk       = Rbac::canAccessModule($role, 'kk');
        $canRumah    = Rbac::canAccessModule($role, 'rumah');

        $totalCitizens     = $canPenduduk ? Citizen::count() : null;
        $totalFamilyCards  = $canKk       ? FamilyCard::count() : null;
        $totalHouses       = $canRumah    ? House::count() : null;
        $pendingVerif      = $canPenduduk
            ? Citizen::where('verification_status', VerificationStatus::Pending)->count()
            : null;

        // Distribusi gender untuk mini chart
        $genderData = $canPenduduk
            ? Citizen::select('gender', DB::raw('count(*) as total'))
                ->groupBy('gender')
                ->pluck('total', 'gender')
            : collect();

        // Status verifikasi breakdown
        $verifBreakdown = $canPenduduk
            ? Citizen::select('verification_status', DB::raw('count(*) as total'))
                ->groupBy('verification_status')
                ->pluck('total', 'verification_status')
            : collect();

        // 5 aktivitas terbaru dari audit log
        $recentActivity = AuditLog::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', [
            'greeting'        => $greeting,
            'canScan'         => Rbac::canAccessModule($role, 'scan'),
            'totalCitizens'   => $totalCitizens,
            'totalFamilyCards'=> $totalFamilyCards,
            'totalHouses'     => $totalHouses,
            'pendingVerif'    => $pendingVerif,
            'genderData'      => $genderData,
            'verifBreakdown'  => $verifBreakdown,
            'recentActivity'  => $recentActivity,
            'today'           => now()->translatedFormat('l, d F Y'),
        ]);
    }
}
