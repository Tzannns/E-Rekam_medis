<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Laundry</title>
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
    <h2>Laporan Laundry</h2>
    <div class="meta">
        Dicetak: {{ now()->format('d/m/Y H:i') }}
    </div>
    <table>
        <thead>
            <tr>
                <th>Tanggal Masuk</th>
                <th>Unit</th>
                <th>Item</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Berat (kg)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $i)
                <tr>
                    <td>{{ optional($i->tanggal_masuk)->format('d/m/Y H:i') }}</td>
                    <td>{{ $i->unit }}</td>
                    <td>{{ $i->item }}</td>
                    <td>{{ $i->jenis }}</td>
                    <td>{{ $i->jumlah }}</td>
                    <td>{{ $i->berat_kg }}</td>
                    <td>{{ $i->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>