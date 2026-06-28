<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('setting.read'), 403);

        return view('settings.index');
    }
}
