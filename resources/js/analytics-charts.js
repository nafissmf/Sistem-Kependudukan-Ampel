import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const PALETTE = ['#2e7d32', '#1565c0', '#ffd54f', '#fb8c00', '#e53935', '#7c3aed', '#0891b2', '#be185d'];

/**
 * Render satu chart ke elemen <canvas id="...">. Dipanggil dari Blade
 * analytics/index.blade.php dengan data yang sudah diagregasi di
 * AnalyticsController (server-side), bukan dihitung di JS.
 */
export function renderChart(canvasId, type, labels, data) {
  const el = document.getElementById(canvasId);
  if (!el) return;

  return new Chart(el, {
    type,
    data: {
      labels,
      datasets: [
        {
          data,
          backgroundColor: PALETTE,
          borderWidth: type === 'line' ? 2 : 0,
          borderColor: type === 'line' ? '#2e7d32' : undefined,
          tension: 0.35,
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: type === 'pie' || type === 'doughnut', position: 'bottom' },
      },
      scales: type === 'bar' || type === 'line' ? { y: { beginAtZero: true, ticks: { precision: 0 } } } : undefined,
    },
  });
}

window.renderChart = renderChart;
