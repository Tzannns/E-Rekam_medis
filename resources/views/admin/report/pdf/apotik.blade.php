<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Apotik</title>
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
    <h2>Laporan Transaksi Apotik</h2>
    <div class="meta">
        Dicetak: {{ now()->format('d/m/Y H:i') }}
    </div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No Transaksi</th>
                <th>Pembeli</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $t)
                <tr>
                    <td>{{ optional($t->created_at)->format('d/m/Y H:i') }}</td>
                    <td>{{ $t->no_transaksi }}</td>
                    <td>{{ $t->nama_pembeli ?: optional(optional($t->pasien)->user)->name }}</td>
                    <td>{{ number_format($t->total,2,',','.') }}</td>
                    <td>{{ $t->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>