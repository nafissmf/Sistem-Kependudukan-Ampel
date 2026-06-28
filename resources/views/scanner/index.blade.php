<x-layouts.app title="Scan QR">
    @vite('resources/js/scanner.js')

    <x-page-header title="Scan QR Code" description="Arahkan kamera ke QR Code pada Rumah atau Kartu Keluarga." />

    <div class="mx-auto max-w-md rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
        <div id="qr-reader" class="overflow-hidden rounded-xl"></div>
        <p class="mt-3 text-center text-xs text-slate-400">
            Izinkan akses kamera saat diminta browser. Hasil scan otomatis mengarahkan ke halaman verifikasi.
        </p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => window.initQrScanner('qr-reader'));
    </script>
</x-layouts.app>
