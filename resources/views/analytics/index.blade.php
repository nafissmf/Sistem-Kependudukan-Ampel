<x-layouts.app title="Analytics">
    @vite('resources/js/analytics-charts.js')

    <x-page-header title="Analytics Kependudukan" :description="'Berdasarkan ' . number_format($totalCitizens, 0, ',', '.') . ' data penduduk terdaftar.'" />

    @if ($totalCitizens === 0)
        <x-empty-state icon="bar-chart-3" title="Belum ada data untuk dianalisis" description="Grafik akan muncul setelah ada data Penduduk." />
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="mb-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">Jenis Kelamin</h2>
                <canvas id="chart-gender"></canvas>
            </div>
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="mb-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">Agama</h2>
                <canvas id="chart-religion"></canvas>
            </div>
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="mb-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">Kelompok Umur</h2>
                <canvas id="chart-age"></canvas>
            </div>
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 sm:col-span-2">
                <h2 class="mb-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">Pendidikan</h2>
                <canvas id="chart-education"></canvas>
            </div>
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="mb-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">Pekerjaan</h2>
                <canvas id="chart-job"></canvas>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.renderChart('chart-gender', 'doughnut', @json($genderChart['labels']), @json($genderChart['data']));
                window.renderChart('chart-religion', 'pie', @json($religionChart['labels']), @json($religionChart['data']));
                window.renderChart('chart-age', 'bar', @json($ageGroupChart['labels']), @json($ageGroupChart['data']));
                window.renderChart('chart-education', 'bar', @json($educationChart['labels']), @json($educationChart['data']));
                window.renderChart('chart-job', 'pie', @json($jobChart['labels']), @json($jobChart['data']));
            });
        </script>
    @endif
</x-layouts.app>
