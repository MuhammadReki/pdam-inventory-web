<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Prediksi Restock</title>
    <style>
        body { font-family: Arial; font-size: 12px; padding: 20px; }
        h1 { color: #0d47a1; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #0d47a1; color: white; padding: 10px; text-align: left; }
        td { border: 1px solid #ddd; padding: 8px; }
        .kritis { background: #fee2e2; color: #dc2626; font-weight: 700; }
        .menipis { background: #fef9c3; color: #d97706; font-weight: 700; }
        .normal { background: #dcfce7; color: #16a34a; font-weight: 700; }
    </style>
</head>
<body>
    <h1>PREDIKSI RESTOCK BARANG</h1>
    <p style="text-align: center;">PDAM Tirta Sago Kota Payakumbuh</p>
    <p style="text-align: center;">Tanggal: {{ now()->translatedFormat('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Rata-rata/Hari</th>
                <th>Hari Tersisa</th>
                <th>Saran Restock</th>
                <th>Urgensi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($prediksi as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['barang']->kode_barang }}</td>
                <td>{{ $item['barang']->nama_barang }}</td>
                <td>{{ $item['barang']->stok }}</td>
                <td>{{ $item['rata_rata'] }}</td>
                <td>{{ $item['hari_tersisa'] }}</td>
                <td>{{ $item['saran_restock'] }}</td>
                <td class="{{ $item['urgensi'] }}">{{ strtoupper($item['urgensi']) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">Tidak ada barang yang perlu restock</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>