<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('scan.read'), 403);

        return view('scanner.index');
    }
}
