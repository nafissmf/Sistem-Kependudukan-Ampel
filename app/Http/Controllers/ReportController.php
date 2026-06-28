<?php

namespace App\Http\Controllers;

use App\Exports\FamilyCardsExport;
use App\Exports\HousesExport;
use App\Models\ExportLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('laporan.read'), 403);

        return view('reports.index');
    }

    public function exportFamilyCards(Request $request): BinaryFileResponse|StreamedResponse|\Illuminate\Http\Response
    {
        abort_unless($request->user()->can('laporan.export'), 403);

        $format = $request->query('format', 'xlsx');
        $filename = 'kartu-keluarga-'.now()->format('Ymd-His');

        ExportLog::create(['filename' => "{$filename}.{$format}", 'module' => 'kk', 'format' => $format, 'created_by' => $request->user()->id]);

        if ($format === 'pdf') {
            $familyCards = (new FamilyCardsExport)->collection();

            return \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.family-cards-pdf', ['familyCards' => $familyCards])->download("{$filename}.pdf");
        }

        return Excel::download(new FamilyCardsExport, "{$filename}.xlsx");
    }

    public function exportHouses(Request $request): BinaryFileResponse|StreamedResponse|\Illuminate\Http\Response
    {
        abort_unless($request->user()->can('laporan.export'), 403);

        $format = $request->query('format', 'xlsx');
        $filename = 'rumah-'.now()->format('Ymd-His');

        ExportLog::create(['filename' => "{$filename}.{$format}", 'module' => 'rumah', 'format' => $format, 'created_by' => $request->user()->id]);

        if ($format === 'pdf') {
            $houses = (new HousesExport)->collection();

            return \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.houses-pdf', ['houses' => $houses])->download("{$filename}.pdf");
        }

        return Excel::download(new HousesExport, "{$filename}.xlsx");
    }
}
