<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} — SIK Ampel</title>
    <meta name="theme-color" content="#2e7d32">

    <script>
        (function () {
            var saved = localStorage.getItem('sik-ampel-theme');
            var dark = saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (dark) document.documentElement.classList.add('dark');
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased" style="font-family: var(--font-sans);" x-data>
    <div class="min-h-screen bg-[var(--bg)]">
        <x-sidebar :role="auth()->user()->role->code" />

        <div class="transition-all duration-200" :class="$store.ui.collapsed ? 'lg:pl-20' : 'lg:pl-64'">
            <x-navbar :user="auth()->user()" />
            <main class="p-4 pb-24 sm:p-6 lg:pb-6">
                {{ $slot }}
            </main>
        </div>

        <x-bottom-nav :role="auth()->user()->role->code" />

        {{-- Toast notifikasi global, dipicu via $store.toast.show(title, desc) --}}
        <div
            x-show="$store.toast.visible" x-cloak x-transition
            class="glass-panel fixed bottom-20 right-4 z-[60] max-w-sm rounded-xl p-4 shadow-lg lg:bottom-4"
        >
            <p class="text-sm font-semibold" x-text="$store.toast.title"></p>
            <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400" x-text="$store.toast.description"></p>
        </div>
    </div>
</body>
</html>
