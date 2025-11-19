<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rawat Jalan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f4f4f4; }
        h2 { margin-bottom: 8px; }
        .meta { margin-bottom: 12px; font-size: 11px; }
    </style>
    </head>
<body>
    @include('admin.report.pdf._header')
    <h2>Laporan Rawat Jalan</h2>
    <div class="meta">
        Dicetak: {{ now()->format('d/m/Y H:i') }}
    </div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Poli</th>
                <th>Dokter</th>
                <th>Pasien</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $r)
                <tr>
                    <td>{{ optional($r->tanggal_kunjungan)->format('d/m/Y') }}</td>
                    <td>{{ optional($r->poli)->nama_poli }}</td>
                    <td>{{ optional(optional($r->dokter)->user)->name }}</td>
                    <td>{{ optional(optional($r->pasien)->user)->name }}</td>
                    <td>{{ $r->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>