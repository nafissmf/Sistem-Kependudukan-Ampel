<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #1e293b; }
        h1 { font-size: 16px; margin-bottom: 2px; }
        p.subtitle { color: #64748b; margin-top: 0; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #cbd5e1; padding: 6px 8px; text-align: left; }
        th { background: #f1f5f9; }
    </style>
</head>
<body>
    <h1>Laporan Rumah</h1>
    <p class="subtitle">Sistem Informasi Kependudukan Kecamatan Ampel — dicetak {{ now()->translatedFormat('d F Y H:i') }}</p>
    <table>
        <thead><tr><th>Nomor Rumah</th><th>Alamat</th><th>Desa</th><th>Koordinat</th><th>Status</th></tr></thead>
        <tbody>
            @foreach ($houses as $house)
                <tr>
                    <td>{{ $house->house_number ?? '-' }}</td>
                    <td>{{ $house->address ?? '-' }}</td>
                    <td>{{ $house->village?->name ?? '-' }}</td>
                    <td>{{ $house->latitude ?? '-' }}, {{ $house->longitude ?? '-' }}</td>
                    <td>{{ $house->verification_status->label() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
