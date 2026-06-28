<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Login' }} — SIK Ampel</title>
    <meta name="theme-color" content="#2e7d32">

    {{-- Terapkan dark mode SEBELUM render pertama, supaya tidak ada "flash"
         warna terang sekejap saat halaman dimuat (mirip next-themes). --}}
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
<body class="antialiased font-sans" style="font-family: var(--font-sans);">
    {{ $slot }}
</body>
</html>
