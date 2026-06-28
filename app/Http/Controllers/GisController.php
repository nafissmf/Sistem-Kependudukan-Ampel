<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GisController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('gis.read'), 403);

        $houses = House::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'house_number', 'latitude', 'longitude', 'verification_status'])
            ->map(fn (House $house) => [
                'id' => $house->id,
                'house_number' => $house->house_number,
                'latitude' => (float) $house->latitude,
                'longitude' => (float) $house->longitude,
                'verification_status' => $house->verification_status->value,
                'url' => route('houses.show', $house),
            ]);

        return view('gis.index', ['houses' => $houses]);
    }
}
