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
        .footer { margin-top: 16px; font-size: 9px; color: #94a3b8; }
    </style>
</head>
<body>
    <h1>Laporan Data Penduduk</h1>
    <p class="subtitle">Sistem Informasi Kependudukan Kecamatan Ampel, Kabupaten Boyolali — dicetak {{ now()->translatedFormat('d F Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>Gender</th>
                <th>Tgl Lahir</th>
                <th>Desa</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($citizens as $citizen)
                <tr>
                    <td>{{ $citizen->nik }}</td>
                    <td>{{ $citizen->fullname }}</td>
                    <td>{{ $citizen->gender->label() }}</td>
                    <td>{{ $citizen->birth_date?->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ $citizen->village?->name ?? '-' }}</td>
                    <td>{{ $citizen->verification_status->label() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="footer">Total {{ $citizens->count() }} data. Dokumen ini digenerate otomatis oleh sistem.</p>
</body>
</html>
