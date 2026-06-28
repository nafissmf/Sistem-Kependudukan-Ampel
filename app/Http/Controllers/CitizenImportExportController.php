<?php

namespace App\Http\Controllers;

use App\Exports\CitizensExport;
use App\Imports\CitizensImport;
use App\Models\ExportLog;
use App\Models\ImportLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CitizenImportExportController extends Controller
{
    public function showImport(Request $request): View
    {
        abort_unless($request->user()->can('import.create'), 403);

        return view('citizens.import');
    }

    /**
     * Langkah 1: upload file, TAMPILKAN preview tanpa menyimpan apa pun ke
     * database — sesuai brief "Import Data: Preview sebelum import."
     */
    public function preview(Request $request): View|RedirectResponse
    {
        abort_unless($request->user()->can('import.create'), 403);

        $request->validate(['file' => ['required', 'file', 'mimes:xlsx,xls,csv']]);

        $tempPath = $request->file('file')->store('temp/imports', 'local');
        $rows = Excel::toCollection(null, $request->file('file'))->first();
        $headings = $rows->first() ?? collect();
        $dataRows = $rows->skip(1);

        return view('citizens.import-preview', [
            'tempPath' => $tempPath,
            'originalName' => $request->file('file')->getClientOriginalName(),
            'headings' => $headings,
            'previewRows' => $dataRows->take(50),
            'totalRows' => $dataRows->count(),
        ]);
    }

    /** Langkah 2: eksekusi import sungguhan dari file yang sudah di-preview. */
    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()->can('import.create'), 403);

        $request->validate(['temp_path' => ['required', 'string'], 'original_name' => ['required', 'string']]);

        $fullPath = Storage::disk('local')->path($request->input('temp_path'));

        $import = new CitizensImport;
        Excel::import($import, $fullPath);

        $failures = $import->failures();
        $totalRows = $this->countDataRows($fullPath);
        $successCount = max(0, $totalRows - $failures->count());

        ImportLog::create([
            'filename' => $request->input('original_name'),
            'module' => 'penduduk',
            'total_data' => $totalRows,
            'success' => $successCount,
            'failed' => $failures->count(),
            'created_by' => $request->user()->id,
        ]);

        Storage::disk('local')->delete($request->input('temp_path'));

        $message = "Import selesai: {$totalRows} baris diproses, {$successCount} berhasil, {$failures->count()} gagal.";

        return redirect()->route('citizens.index')->with('success', $message);
    }

    public function export(Request $request): BinaryFileResponse|StreamedResponse|\Illuminate\Http\Response
    {
        abort_unless($request->user()->can('export.create'), 403);

        $format = $request->query('format', 'xlsx');
        $filters = $request->only(['village_id', 'verification_status']);
        $filename = 'penduduk-'.now()->format('Ymd-His');

        ExportLog::create([
            'filename' => "{$filename}.{$format}",
            'module' => 'penduduk',
            'format' => $format,
            'created_by' => $request->user()->id,
        ]);

        if ($format === 'pdf') {
            $citizens = (new CitizensExport($filters))->collection();
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('citizens.export-pdf', ['citizens' => $citizens]);

            return $pdf->download("{$filename}.pdf");
        }

        return Excel::download(new CitizensExport($filters), "{$filename}.xlsx");
    }

    /** Total baris DATA (heading row tidak dihitung). */
    private function countDataRows(string $fullPath): int
    {
        $rows = Excel::toCollection(null, $fullPath)->first();

        return max(0, $rows->count() - 1);
    }
}
