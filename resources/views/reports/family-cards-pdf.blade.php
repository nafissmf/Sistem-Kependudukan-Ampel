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
    <h1>Laporan Kartu Keluarga</h1>
    <p class="subtitle">Sistem Informasi Kependudukan Kecamatan Ampel — dicetak {{ now()->translatedFormat('d F Y H:i') }}</p>
    <table>
        <thead><tr><th>Nomor KK</th><th>Kepala Keluarga</th><th>Desa</th><th>Anggota</th><th>Status</th></tr></thead>
        <tbody>
            @foreach ($familyCards as $familyCard)
                <tr>
                    <td>{{ $familyCard->number }}</td>
                    <td>{{ $familyCard->headCitizen?->fullname ?? '-' }}</td>
                    <td>{{ $familyCard->village?->name ?? '-' }}</td>
                    <td>{{ $familyCard->members_count }}</td>
                    <td>{{ $familyCard->verification_status->label() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
