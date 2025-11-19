<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Antrian Online</title>
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
    <h2>Laporan Antrian Online</h2>
    <div class="meta">
        Dicetak: {{ now()->format('d/m/Y H:i') }}
    </div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Poli</th>
                <th>Dokter</th>
                <th>Pasien</th>
                <th>No</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $a)
                <tr>
                    <td>{{ optional($a->tanggal_usulan)->format('d/m/Y') }}</td>
                    <td>{{ $a->jam_usulan }}</td>
                    <td>{{ optional($a->poli)->nama_poli }}</td>
                    <td>{{ optional(optional($a->dokter)->user)->name }}</td>
                    <td>{{ optional(optional($a->pasien)->user)->name }}</td>
                    <td>{{ $a->nomor_antrian }}</td>
                    <td>{{ $a->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>