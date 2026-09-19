@extends('layouts.app')

@section('title', 'Laporan Inventory')
@section('page-title', 'Laporan Inventory')
@section('breadcrumb', 'Laporan')

@section('content')

<style>
    /* ===== OVERRIDE STYLE BUAT HALAMAN LAPORAN ===== */
    .laporan-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px 30px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        border: 1px solid #e8edf3;
    }

    .laporan-card .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e8edf3;
        padding-bottom: 18px;
        margin-bottom: 22px;
    }

    .laporan-card .card-header h5 {
        font-weight: 700;
        color: #0a1628;
        margin: 0;
        font-size: 1.1rem;
    }

    .laporan-card .badge-count {
        background: rgba(13, 71, 161, 0.1);
        color: #0d47a1;
        padding: 4px 16px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Form Filter */
    .laporan-card label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #546e7a;
        margin-bottom: 5px;
    }

    .laporan-card .form-control,
    .laporan-card .form-select {
        border-radius: 12px;
        padding: 10px 14px;
        border: 2px solid #e8edf3;
        font-size: 0.9rem;
        background: #fafbfc;
        color: #1a2332;
    }

    .laporan-card .form-control:focus,
    .laporan-card .form-select:focus {
        border-color: #0d47a1;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(13, 71, 161, 0.08);
    }

    /* Tombol */
    .btn-laporan {
        background: linear-gradient(135deg, #0d47a1, #1565c0);
        border: none;
        color: #ffffff;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-laporan:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(13, 71, 161, 0.3);
        color: #ffffff;
    }

    .btn-laporan-pdf {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }

    .btn-laporan-pdf:hover {
        box-shadow: 0 8px 20px rgba(220, 38, 38, 0.3);
    }

    .btn-laporan-excel {
        background: linear-gradient(135deg, #16a34a, #15803d);
    }

    .btn-laporan-excel:hover {
        box-shadow: 0 8px 20px rgba(22, 163, 74, 0.3);
    }

    /* Statistik Card */
    .stat-laporan {
        background: #ffffff;
        border-radius: 16px;
        padding: 22px 24px;
        border: 1px solid #e8edf3;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
    }

    .stat-laporan:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    .stat-laporan .stat-label {
        font-size: 0.7rem;
        color: #78909c;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin: 0;
    }

    .stat-laporan .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: #0a1628;
        margin: 4px 0 0 0;
        letter-spacing: -1px;
    }

    .stat-laporan.blue { border-left: 4px solid #2563eb; }
    .stat-laporan.green { border-left: 4px solid #16a34a; }
    .stat-laporan.red { border-left: 4px solid #dc2626; }

    /* Tabel Laporan */
    .table-laporan {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    .table-laporan thead th {
        background: #f0f4f8;
        color: #546e7a;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 14px 18px;
        border: none;
    }

    .table-laporan thead th:first-child { border-radius: 12px 0 0 12px; }
    .table-laporan thead th:last-child { border-radius: 0 12px 12px 0; }

    .table-laporan tbody tr {
        background: #fafbfc;
        transition: all 0.3s ease;
    }

    .table-laporan tbody tr:hover {
        background: #f0f4f8;
        transform: scale(1.005);
    }

    .table-laporan tbody td {
        padding: 14px 18px;
        border: none;
        vertical-align: middle;
        color: #1a2332;
        font-size: 0.88rem;
    }

    .table-laporan tbody tr td:first-child { border-radius: 12px 0 0 12px; }
    .table-laporan tbody tr td:last-child { border-radius: 0 12px 12px 0; }

    /* Badge */
    .badge-kode {
        background: rgba(13, 71, 161, 0.1);
        color: #0d47a1;
        padding: 4px 14px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .badge-jenis {
        padding: 5px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.7rem;
    }

    .badge-jenis.masuk {
        background: rgba(22, 163, 74, 0.15);
        color: #16a34a;
    }

    .badge-jenis.keluar {
        background: rgba(220, 38, 38, 0.15);
        color: #dc2626;
    }
</style>

<div class="laporan-card">
    <div class="card-header">
        <h5>📄 Laporan Inventory</h5>
        <span class="badge-count">{{ $totalTransaksi }} Transaksi</span>
    </div>

    {{-- FILTER --}}
    <form method="GET" action="{{ route('laporan.index') }}" style="margin-bottom: 20px;">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label>Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-3">
                <label>Tanggal Selesai</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-3">
                <label>Jenis</label>
                <select name="jenis" class="form-select">
                    <option value="semua" {{ $jenis == 'semua' ? 'selected' : '' }}>Semua</option>
                    <option value="masuk" {{ $jenis == 'masuk' ? 'selected' : '' }}>Masuk</option>
                    <option value="keluar" {{ $jenis == 'keluar' ? 'selected' : '' }}>Keluar</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn-laporan w-100 justify-content-center">
                    <i class="bi bi-funnel"></i> Tampilkan
                </button>
            </div>
        </div>
    </form>

    {{-- TOMBOL EXPORT --}}
    <div style="display: flex; gap: 10px; margin-bottom: 24px;">
        <a href="{{ route('laporan.export.pdf', ['start_date' => $startDate, 'end_date' => $endDate, 'jenis' => $jenis]) }}" 
           class="btn-laporan btn-laporan-pdf" 
           target="_blank">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
        <a href="{{ route('laporan.export.excel', ['start_date' => $startDate, 'end_date' => $endDate, 'jenis' => $jenis]) }}" 
           class="btn-laporan btn-laporan-excel">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
    </div>

    {{-- STATISTIK --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-laporan blue">
                <p class="stat-label">Total Transaksi</p>
                <h3 class="stat-value">{{ $totalTransaksi }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-laporan green">
                <p class="stat-label">Barang Masuk</p>
                <h3 class="stat-value">{{ number_format($totalMasuk, 0, ',', '.') }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-laporan red">
                <p class="stat-label">Barang Keluar</p>
                <h3 class="stat-value">{{ number_format($totalKeluar, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    {{-- TABEL LAPORAN --}}
    <div class="table-responsive">
        <table class="table-laporan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d M Y') }}</td>
                    <td><span class="badge-kode">{{ $item['kode'] }}</span></td>
                    <td>{{ $item['nama'] }}</td>
                    <td>
                        <span class="badge-jenis {{ $item['jenis'] == 'Masuk' ? 'masuk' : 'keluar' }}">
                            {{ $item['jenis'] }}
                        </span>
                    </td>
                    <td>{{ $item['jumlah'] }}</td>
                    <td>{{ $item['keterangan'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">
                        Tidak ada data untuk periode ini
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- FOOTER INFO --}}
    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e8edf3; display: flex; justify-content: space-between; font-size: 0.8rem; color: #78909c;">
        <div>
            <i class="bi bi-info-circle"></i> 
            Periode: <strong style="color: #0a1628;">{{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}</strong>
        </div>
        <div>
            Total: <strong style="color: #0a1628;">{{ $laporan->count() }} transaksi</strong>
        </div>
    </div>
</div>

@endsection