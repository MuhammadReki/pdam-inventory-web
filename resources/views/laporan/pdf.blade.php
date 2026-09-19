<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #0d47a1;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #0d47a1;
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        .info {
            margin-bottom: 15px;
            font-size: 11px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 3px 0;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data th {
            background: #0d47a1;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        table.data td {
            border: 1px solid #ddd;
            padding: 6px;
            font-size: 10px;
        }
        table.data tr:nth-child(even) {
            background: #f5f5f5;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature .name {
            margin-top: 60px;
            font-weight: bold;
            border-top: 1px solid #333;
            display: inline-block;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h1>LAPORAN INVENTORY BARANG</h1>
        <p>PDAM Tirta Sago Kota Payakumbuh</p>
    </div>

    {{-- Info --}}
    <div class="info">
        <table>
            <tr>
                <td><strong>Periode:</strong></td>
                <td>{{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</td>
                <td><strong>Jenis:</strong></td>
                <td>{{ ucfirst($jenis) }}</td>
            </tr>
            <tr>
                <td><strong>Total Transaksi:</strong></td>
                <td>{{ $totalTransaksi }}</td>
                <td><strong>Tanggal Cetak:</strong></td>
                <td>{{ now()->translatedFormat('d F Y H:i') }}</td>
            </tr>
        </table>
    </div>

    {{-- Tabel Data --}}
    <table class="data">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 12%;">Kode</th>
                <th style="width: 25%;">Nama Barang</th>
                <th style="width: 10%;">Jenis</th>
                <th style="width: 10%;">Jumlah</th>
                <th style="width: 26%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d/m/Y') }}</td>
                <td>{{ $item['kode'] }}</td>
                <td>{{ $item['nama'] }}</td>
                <td>{{ $item['jenis'] }}</td>
                <td>{{ $item['jumlah'] }}</td>
                <td>{{ $item['keterangan'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px;">
                    Tidak ada data untuk periode ini
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Total --}}
    <div style="margin-top: 15px; font-size: 11px;">
        <strong>Total Barang Masuk:</strong> {{ $totalMasuk }} unit |
        <strong>Total Barang Keluar:</strong> {{ $totalKeluar }} unit
    </div>

    {{-- Tanda Tangan --}}
    <div class="signature">
        <p>Payakumbuh, {{ now()->translatedFormat('d F Y') }}</p>
        <p>Pembimbing Lapangan</p>
        <div class="name">Hengki Yudi Putra, ST</div>
    </div>

</body>
</html>