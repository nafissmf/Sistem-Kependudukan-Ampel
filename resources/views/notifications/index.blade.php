<x-layouts.app title="Notifikasi">
    <x-page-header title="Notifikasi" />

    @if (session('success'))
        <div class="mb-4 rounded-xl bg-primary-50 px-4 py-3 text-sm text-primary-700 dark:bg-primary-600/15 dark:text-primary-300">{{ session('success') }}</div>
    @endif

    <div class="overflow-hidden rounded-card border border-[var(--border)] bg-[var(--card-bg)] shadow-sm">
        @if ($notifications->isEmpty())
            <x-empty-state icon="bell" title="Belum ada notifikasi" />
        @else
            <ul class="divide-y divide-[var(--border)]">
                @foreach ($notifications as $notification)
                    <li>
                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                            @csrf
                            <button type="submit" class="flex w-full items-start gap-3 p-4 text-left hover:bg-slate-50 dark:hover:bg-white/5 {{ $notification->read_at ? 'opacity-60' : '' }}">
                                <span class="mt-1 size-2 shrink-0 rounded-full {{ $notification->read_at ? 'bg-transparent' : 'bg-primary-600' }}"></span>
                                <div>
                                    <p class="font-medium">{{ $notification->data['module_label'] ?? 'Notifikasi' }} — {{ $notification->data['decision_label'] ?? '' }}</p>
                                    <p class="text-sm text-slate-500">{{ $notification->data['title'] ?? '' }}</p>
                                    @if (! empty($notification->data['note']))
                                        <p class="mt-1 text-xs text-slate-400">Catatan: {{ $notification->data['note'] }}</p>
                                    @endif
                                    <p class="mt-1 text-xs text-slate-400">{{ $notification->created_at->translatedFormat('d M Y H:i') }}</p>
                                </div>
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
            <div class="border-t border-[var(--border)] p-4">{{ $notifications->links() }}</div>
        @endif
    </div>
</x-layouts.app>
