<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('audit.read'), 403);

        $logs = AuditLog::query()
            ->with('user:id,fullname,username')
            ->when($request->query('module'), fn ($q, $module) => $q->where('module', $module))
            ->when($request->query('action'), fn ($q, $action) => $q->where('action', $action))
            ->when($request->query('user_id'), fn ($q, $userId) => $q->where('user_id', $userId))
            ->when($request->query('date_from'), fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
            ->when($request->query('date_to'), fn ($q, $date) => $q->whereDate('created_at', '<=', $date))
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        return view('audit.index', [
            'logs' => $logs,
            'modules' => AuditLog::query()->distinct()->orderBy('module')->pluck('module'),
            'actions' => \App\Enums\AuditAction::cases(),
            'filters' => $request->only(['module', 'action', 'user_id', 'date_from', 'date_to']),
        ]);
    }
}
