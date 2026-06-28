<x-layouts.app title="Audit Log">
    <x-page-header title="Audit Log" description="Riwayat seluruh aktivitas penting di sistem." />

    <form method="GET" class="mb-4 grid grid-cols-1 gap-3 rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-4 sm:grid-cols-2 lg:grid-cols-5">
        <select name="module" class="h-10 rounded-xl border border-[var(--border)] bg-[var(--bg)] px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            <option value="">Semua Modul</option>
            @foreach ($modules as $module)
                <option value="{{ $module }}" @selected(($filters['module'] ?? null) === $module)>{{ $module }}</option>
            @endforeach
        </select>
        <select name="action" class="h-10 rounded-xl border border-[var(--border)] bg-[var(--bg)] px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            <option value="">Semua Aksi</option>
            @foreach ($actions as $action)
                <option value="{{ $action->value }}" @selected(($filters['action'] ?? null) === $action->value)>{{ $action->value }}</option>
            @endforeach
        </select>
        <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="h-10 rounded-xl border border-[var(--border)] bg-[var(--bg)] px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="h-10 rounded-xl border border-[var(--border)] bg-[var(--bg)] px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
        <div class="flex gap-2">
            <button type="submit" class="flex h-10 flex-1 items-center justify-center gap-2 rounded-xl bg-primary-600 px-4 text-sm font-medium text-white hover:bg-primary-700"><x-icon name="search" class="size-4" /> Filter</button>
            <a href="{{ route('audit.index') }}" class="flex h-10 items-center justify-center rounded-xl border border-[var(--border)] px-3 text-sm text-slate-500 hover:bg-slate-50 dark:hover:bg-white/5">Reset</a>
        </div>
    </form>

    <div class="overflow-hidden rounded-card border border-[var(--border)] bg-[var(--card-bg)] shadow-sm">
        @if ($logs->isEmpty())
            <x-empty-state icon="shield-check" title="Belum ada aktivitas tercatat" />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-[var(--border)] bg-slate-50 text-xs uppercase text-slate-500 dark:bg-white/5">
                        <tr>
                            <th class="px-4 py-3 font-medium">Waktu</th>
                            <th class="px-4 py-3 font-medium">User</th>
                            <th class="px-4 py-3 font-medium">Modul</th>
                            <th class="px-4 py-3 font-medium">Aksi</th>
                            <th class="px-4 py-3 font-medium">IP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border)]">
                        @foreach ($logs as $log)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5">
                                <td class="px-4 py-3 text-xs text-slate-500">{{ $log->created_at->translatedFormat('d M Y H:i:s') }}</td>
                                <td class="px-4 py-3">{{ $log->user?->fullname ?? 'Sistem' }}</td>
                                <td class="px-4 py-3"><span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs dark:bg-white/5">{{ $log->module }}</span></td>
                                <td class="px-4 py-3 text-xs font-medium">{{ $log->action->value }}</td>
                                <td class="px-4 py-3 font-mono text-xs text-slate-400" style="font-family: var(--font-mono);">{{ $log->ip_address ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-[var(--border)] p-4">{{ $logs->links() }}</div>
        @endif
    </div>
</x-layouts.app>
