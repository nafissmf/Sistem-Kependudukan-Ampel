// Dijalankan sekali secara manual (node scripts/generate-icons.mjs), BUKAN
// bagian dari `npm run build`. Tujuannya: mengekstrak markup SVG asli dari
// paket `lucide-static` supaya komponen <x-icon> di Blade selalu identik
// pixel-perfect dengan ikon Lucide, tanpa kita ketik ulang path data secara
// manual (rawan salah ketik koordinat).
import { readFileSync, writeFileSync } from 'node:fs';

const ICONS = [
  'layout-dashboard', 'users', 'id-card', 'home', 'shield-check', 'map',
  'qr-code', 'bar-chart-3', 'file-text', 'user-cog', 'lock', 'bell',
  'settings', 'search', 'sun', 'moon', 'menu', 'x', 'log-out', 'user',
  'panel-left-close', 'panel-left-open', 'eye', 'eye-off', 'refresh-cw',
  'cloud-sun', 'landmark', 'building-2', 'shield-half', 'alert-triangle',
  'compass', 'shield-alert', 'scan-line', 'check-circle-2', 'circle',
  'chevron-down',
];

let phpCases = '';

for (const icon of ICONS) {
  const svg = readFileSync(`node_modules/lucide-static/icons/${icon}.svg`, 'utf8');
  const inner = svg.match(/<svg[^>]*>([\s\S]*)<\/svg>/)[1].trim();
  phpCases += `            '${icon}' => '${inner.replace(/'/g, "\\'")}',\n`;
}

const php = `<?php

// ⚠️ FILE INI DI-GENERATE OTOMATIS oleh scripts/generate-icons.mjs dari
// paket npm "lucide-static". Jangan edit manual — kalau perlu menambah
// ikon baru, tambahkan namanya di scripts/generate-icons.mjs lalu jalankan
// ulang scriptnya.

return [
${phpCases}];
`;

writeFileSync('resources/icons.php', php);
console.log(`Generated resources/icons.php with ${ICONS.length} icons.`);
