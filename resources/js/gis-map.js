import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

// Marker icon default Leaflet butuh path gambar — pakai CDN supaya tidak
// perlu copy asset gambar manual ke public/build (keterbatasan bundling
// Vite untuk image asset Leaflet).
const markerIconBase = 'https://unpkg.com/leaflet@1.9.4/dist/images/';
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
  iconRetinaUrl: markerIconBase + 'marker-icon-2x.png',
  iconUrl: markerIconBase + 'marker-icon.png',
  shadowUrl: markerIconBase + 'marker-shadow.png',
});

const STATUS_COLOR = {
  APPROVED: '#2e7d32', // hijau = terverifikasi
  PENDING: '#fb8c00', // kuning/oranye = pending
  REJECTED: '#e53935', // merah = ditolak
  REVISION: '#1565c0', // biru = revisi
};

function coloredDivIcon(color) {
  return L.divIcon({
    className: '',
    html: `<span style="background:${color};width:16px;height:16px;display:block;border-radius:50%;border:2px solid white;box-shadow:0 1px 4px rgba(0,0,0,.4)"></span>`,
    iconSize: [16, 16],
  });
}

/**
 * Inisialisasi peta GIS. `houses` adalah array hasil JSON dari endpoint
 * /api/v1/houses/map: [{ id, house_number, latitude, longitude, verification_status, url }]
 */
export function initGisMap(elementId, houses, center = [-7.45, 110.55]) {
  const map = L.map(elementId).setView(center, 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors',
    maxZoom: 19,
  }).addTo(map);

  const markers = [];

  houses.forEach((house) => {
    if (!house.latitude || !house.longitude) return;

    const color = STATUS_COLOR[house.verification_status] ?? '#64748b';
    const marker = L.marker([house.latitude, house.longitude], { icon: coloredDivIcon(color) })
      .addTo(map)
      .bindPopup(
        `<strong>${house.house_number ?? 'Rumah'}</strong><br>` +
          `Status: ${house.verification_status}<br>` +
          `<a href="${house.url}" class="text-primary-600">Lihat Detail →</a>`,
      );
    markers.push(marker);
  });

  if (markers.length > 0) {
    const group = L.featureGroup(markers);
    map.fitBounds(group.getBounds(), { padding: [30, 30] });
  }

  return map;
}

window.initGisMap = initGisMap;
