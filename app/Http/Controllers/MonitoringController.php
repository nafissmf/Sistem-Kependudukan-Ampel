<?php

namespace App\Http\Controllers;

use App\Models\DatabaseBackup;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class MonitoringController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('setting.read'), 403);

        return view('monitoring.index', [
            'database' => $this->checkDatabase(),
            'queue' => $this->checkQueue(),
            'storage' => $this->checkStorage(),
            'lastBackup' => DatabaseBackup::latest('backup_date')->first(),
            'phpVersion' => PHP_VERSION,
            'laravelVersion' => app()->version(),
        ]);
    }

    private function checkDatabase(): array
    {
        try {
            DB::connection()->getPdo();

            return ['status' => 'OK', 'driver' => config('database.default')];
        } catch (Throwable $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    private function checkQueue(): array
    {
        try {
            $pending = DB::table('jobs')->count();
            $failed = DB::table('failed_jobs')->count();

            return ['status' => 'OK', 'pending' => $pending, 'failed' => $failed];
        } catch (Throwable $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }

    private function checkStorage(): array
    {
        try {
            $disk = Storage::disk('public');
            $files = $disk->allFiles();
            $totalSize = array_sum(array_map(fn ($f) => $disk->size($f), $files));

            return ['status' => 'OK', 'file_count' => count($files), 'total_size' => $totalSize];
        } catch (Throwable $e) {
            return ['status' => 'ERROR', 'message' => $e->getMessage()];
        }
    }
}
