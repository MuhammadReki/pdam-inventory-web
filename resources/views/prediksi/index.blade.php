@extends('layouts.app')

@section('title', 'Prediksi Restock')
@section('page-title', 'Prediksi Restock')
@section('breadcrumb', 'Prediksi Restock')

@section('content')

<style>
    .prediksi-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px 30px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        border: 1px solid #e8edf3;
        margin-bottom: 24px;
    }

    .prediksi-card h5 {
        color: #0a1628;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .ai-summary {
        background: linear-gradient(135deg, #0d47a1, #1565c0);
        color: #ffffff;
        padding: 20px 24px;
        border-radius: 16px;
        margin-bottom: 24px;
    }

    .ai-summary h5 { color: #ffffff; margin-bottom: 8px; }
    .ai-summary p  { margin: 0; opacity: 0.9; font-size: 0.9rem; }

    .stat-mini {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e8edf3;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    }

    .stat-mini .label {
        font-size: 0.7rem;
        color: #78909c;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin: 0;
    }

    .stat-mini .value {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0a1628;
        margin: 4px 0 0 0;
    }

    .stat-mini.blue  { border-left: 4px solid #2563eb; }
    .stat-mini.green { border-left: 4px solid #16a34a; }
    .stat-mini.yellow { border-left: 4px solid #d97706; }
    .stat-mini.red   { border-left: 4px solid #dc2626; }

    .prediksi-item {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 12px;
        border-left: 4px solid #16a34a;
        transition: all 0.3s ease;
    }

    .prediksi-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    .prediksi-item.kritis {
        border-left-color: #dc2626;
        background: #fef2f2;
    }

    .prediksi-item.menipis {
        border-left-color: #d97706;
        background: #fffbeb;
    }

    .prediksi-item.normal { border-left-color: #16a34a; }

    .prediksi-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .prediksi-header h6 {
        margin: 0;
        font-weight: 700;
        color: #0a1628;
        font-size: 1.1rem;
    }

    .badge-urgensi {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .badge-urgensi.kritis  { background: #fee2e2; color: #dc2626; }
    .badge-urgensi.menipis { background: #fef9c3; color: #d97706; }
    .badge-urgensi.normal  { background: #dcfce7; color: #16a34a; }

    .prediksi-detail {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .prediksi-detail .item {
        text-align: center;
        padding: 8px;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 10px;
    }

    .prediksi-detail .label {
        font-size: 0.7rem;
        color: #64748b;
        text-transform: uppercase;
        font-weight: 600;
    }

    .prediksi-detail .value {
        font-size: 1.2rem;
        font-weight: 800;
        color: #0a1628;
        margin-top: 4px;
    }

    .prediksi-detail .value.merah  { color: #dc2626; }
    .prediksi-detail .value.kuning { color: #d97706; }
    .prediksi-detail .value.hijau  { color: #16a34a; }

    .analisis-list .item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .analisis-list .item:last-child { border-bottom: none; }

    @media (max-width: 768px) {
        .prediksi-detail { grid-template-columns: repeat(2, 1fr); }
    }
</style>

{{-- AI SUMMARY --}}
<div class="ai-summary">
    <h5>🤖 AI Summary</h5>
    <p>
        Total <strong>{{ $aiSummary['total_barang'] }} jenis barang</strong>
        dengan nilai aset <strong>Rp {{ number_format($aiSummary['nilai_aset'], 0, ',', '.') }}</strong>.
        Bulan ini: <strong>{{ $aiSummary['total_masuk'] }} unit masuk</strong>,
        <strong>{{ $aiSummary['total_keluar'] }} unit keluar</strong>.
        @if($aiSummary['perlu_restock'] > 0)
            <br>⚠️ <strong>{{ $aiSummary['perlu_restock'] }} barang</strong> perlu restock dalam 30 hari.
            @if($aiSummary['barang_urgent'])
                Yang paling urgent: <strong>{{ $aiSummary['barang_urgent']['barang']->nama_barang }}</strong>
                ({{ $aiSummary['barang_urgent']['hari_tersisa'] }} hari lagi).
            @endif
        @else
            <br>✅ Semua stok aman!
        @endif
    </p>
</div>

{{-- STATISTIK --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-mini blue">
            <p class="label">📦 Total Barang</p>
            <h3 class="value">{{ $totalBarang }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-mini green">
            <p class="label">📊 Total Stok</p>
            <h3 class="value">{{ number_format($totalStok, 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-mini yellow">
            <p class="label">💰 Nilai Aset</p>
            <h3 class="value" style="font-size: 1.1rem;">Rp {{ number_format($totalNilaiAset, 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-mini red">
            <p class="label">⚠️ Perlu Restock</p>
            <h3 class="value">{{ $aiSummary['perlu_restock'] }}</h3>
        </div>
    </div>
</div>

{{-- PREDIKSI RESTOCK --}}
<div class="prediksi-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h5 style="margin: 0;">🔮 Prediksi Restock</h5>
        <a href="{{ route('prediksi.export.pdf') }}" class="btn-premium" target="_blank">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>

    @forelse($prediksi as $item)
        <div class="prediksi-item {{ $item['urgensi'] }}">
            <div class="prediksi-header">
                <h6>{{ $item['barang']->nama_barang }}</h6>
                <span class="badge-urgensi {{ $item['urgensi'] }}">
                    {{ $item['urgensi'] }}
                </span>
            </div>

            <div class="prediksi-detail">
                <div class="item">
                    <div class="label">Stok</div>
                    <div class="value">{{ $item['barang']->stok }}</div>
                </div>
                <div class="item">
                    <div class="label">Rata-rata/Hari</div>
                    <div class="value">{{ $item['rata_rata'] }}</div>
                </div>
                <div class="item">
                    <div class="label">Hari Tersisa</div>
                    <div class="value {{ $item['hari_tersisa'] <= 7 ? 'merah' : ($item['hari_tersisa'] <= 15 ? 'kuning' : 'hijau') }}">
                        {{ $item['hari_tersisa'] }}
                    </div>
                </div>
                <div class="item">
                    <div class="label">Saran Restock</div>
                    <div class="value hijau">{{ $item['saran_restock'] }}</div>
                </div>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 40px; color: #64748b;">
            <i class="bi bi-check-circle" style="font-size: 3rem; color: #16a34a;"></i>
            <p style="margin-top: 12px; font-size: 1rem;">
                Semua stok aman! Nggak ada barang yang perlu restock.
            </p>
        </div>
    @endforelse
</div>

{{-- ANALISIS BARANG MASUK --}}
<div class="prediksi-card">
    <h5>📥 Analisis Barang Masuk (3 Bulan Terakhir)</h5>

    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="stat-mini blue">
                <p class="label">Total Transaksi</p>
                <h3 class="value">{{ $analisisMasuk['total_transaksi'] }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-mini green">
                <p class="label">Total Unit Masuk</p>
                <h3 class="value">{{ number_format($analisisMasuk['total_unit'], 0, ',', '.') }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-mini yellow">
                <p class="label">Total Nilai</p>
                <h3 class="value" style="font-size: 1.1rem;">Rp {{ number_format($analisisMasuk['total_nilai'], 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <h6 style="font-weight: 700; color: #0a1628;">🏢 Supplier Teraktif</h6>
            <div class="analisis-list">
                @forelse($analisisMasuk['supplier'] as $s)
                    <div class="item">
                        <span>{{ $s->keterangan ?? '-' }}</span>
                        <strong>{{ $s->total }} transaksi</strong>
                    </div>
                @empty
                    <p style="color: #64748b;">Belum ada data</p>
                @endforelse
            </div>
        </div>

        <div class="col-md-6">
            <h6 style="font-weight: 700; color: #0a1628;">📦 Barang Sering Di-restock</h6>
            <div class="analisis-list">
                @forelse($analisisMasuk['barang_sering'] as $b)
                    <div class="item">
                        <span>{{ $b->barang->nama_barang ?? '-' }}</span>
                        <strong>{{ $b->total }} unit</strong>
                    </div>
                @empty
                    <p style="color: #64748b;">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection