<x-layouts.app title="GIS Persebaran Rumah">
    @vite('resources/js/gis-map.js')

    <x-page-header title="GIS — Persebaran Rumah" description="Peta lokasi rumah berdasarkan koordinat GPS yang sudah diinput Operator Desa." />

    <div class="mb-3 flex flex-wrap gap-3 text-xs">
        <span class="flex items-center gap-1.5"><span class="size-3 rounded-full" style="background:#2e7d32"></span> Terverifikasi</span>
        <span class="flex items-center gap-1.5"><span class="size-3 rounded-full" style="background:#fb8c00"></span> Pending</span>
        <span class="flex items-center gap-1.5"><span class="size-3 rounded-full" style="background:#e53935"></span> Ditolak</span>
        <span class="flex items-center gap-1.5"><span class="size-3 rounded-full" style="background:#1565c0"></span> Revisi</span>
    </div>

    @if ($houses->isEmpty())
        <x-empty-state icon="map" title="Belum ada rumah dengan koordinat GPS" description="Tambahkan rumah dengan tombol 'Ambil Lokasi Saat Ini' di form Rumah agar muncul di peta." />
    @else
        <div id="gis-map" class="h-[60vh] w-full rounded-card border border-[var(--border)]"></div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const houses = @json($houses);
            if (houses.length > 0) window.initGisMap('gis-map', houses);
        });
    </script>
</x-layouts.app>
