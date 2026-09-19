<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Carbon\Carbon;

class PrediksiController extends Controller
{
    public function index()
    {
        // ============================================
        // 1. STATISTIK UMUM
        // ============================================
        $totalBarang    = Barang::count();
        $totalStok      = Barang::sum('stok');
        $totalNilaiAset = Barang::sum(\DB::raw('stok * harga'));

        $bulanIni       = now()->startOfMonth();
        $totalMasuk     = BarangMasuk::where('tanggal_masuk', '>=', $bulanIni)->sum('jumlah');
        $totalKeluar    = BarangKeluar::where('tanggal_keluar', '>=', $bulanIni)->sum('jumlah');

        // ============================================
        // 2. PREDIKSI RESTOCK
        // ============================================
        $barangs = Barang::all();
        $prediksi = [];

        foreach ($barangs as $barang) {
            $transaksi = BarangKeluar::where('barang_id', $barang->id)
                ->where('tanggal_keluar', '>=', now()->subMonths(3))
                ->get();

            if ($transaksi->count() == 0) continue;

            $totalKeluarBarang = $transaksi->sum('jumlah');
            $hariAktif         = $transaksi->pluck('tanggal_keluar')->unique()->count();
            $rataRataPerHari   = $hariAktif > 0 ? $totalKeluarBarang / $hariAktif : 0;
            $hariTersisa       = $rataRataPerHari > 0 ? round($barang->stok / $rataRataPerHari) : 999;
            $saranRestock      = ceil($rataRataPerHari * 30);

            if ($hariTersisa <= 30 && $rataRataPerHari > 0) {
                $prediksi[] = [
                    'barang'        => $barang,
                    'total_keluar'  => $totalKeluarBarang,
                    'hari_aktif'    => $hariAktif,
                    'rata_rata'     => round($rataRataPerHari, 2),
                    'hari_tersisa'  => $hariTersisa,
                    'saran_restock' => $saranRestock,
                    'urgensi'       => $hariTersisa <= 7
                        ? 'kritis'
                        : ($hariTersisa <= 15 ? 'menipis' : 'normal'),
                ];
            }
        }

        usort($prediksi, fn($a, $b) => $a['hari_tersisa'] <=> $b['hari_tersisa']);

        // ============================================
        // 3. ANALISIS BARANG MASUK
        // ============================================
        $analisisMasuk = [
            'total_transaksi' => BarangMasuk::where('tanggal_masuk', '>=', now()->subMonths(3))->count(),
            'total_unit'      => BarangMasuk::where('tanggal_masuk', '>=', now()->subMonths(3))->sum('jumlah'),
            'total_nilai'     => BarangMasuk::where('tanggal_masuk', '>=', now()->subMonths(3))
                ->join('barangs', 'barang_masuks.barang_id', '=', 'barangs.id')
                ->sum(\DB::raw('barang_masuks.jumlah * barangs.harga')),
            'supplier'        => BarangMasuk::where('tanggal_masuk', '>=', now()->subMonths(3))
                ->select('keterangan', \DB::raw('count(*) as total'))
                ->groupBy('keterangan')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get(),
            'barang_sering'   => BarangMasuk::where('tanggal_masuk', '>=', now()->subMonths(3))
                ->select('barang_id', \DB::raw('sum(jumlah) as total'))
                ->groupBy('barang_id')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->with('barang')
                ->get(),
        ];

        // ============================================
        // 4. AI SUMMARY
        // ============================================
        $aiSummary = [
            'total_barang'    => $totalBarang,
            'nilai_aset'      => $totalNilaiAset,
            'total_masuk'     => $totalMasuk,
            'total_keluar'    => $totalKeluar,
            'perlu_restock'   => count($prediksi),
            'barang_urgent'   => $prediksi[0] ?? null,
        ];

        return view('prediksi.index', compact(
            'totalBarang',
            'totalStok',
            'totalNilaiAset',
            'totalMasuk',
            'totalKeluar',
            'prediksi',
            'analisisMasuk',
            'aiSummary'
        ));
    }

    public function exportPdf()
    {
        // Logika sama dengan index() — untuk export
        $barangs = Barang::all();
        $prediksi = [];

        foreach ($barangs as $barang) {
            $transaksi = BarangKeluar::where('barang_id', $barang->id)
                ->where('tanggal_keluar', '>=', now()->subMonths(3))
                ->get();

            if ($transaksi->count() == 0) continue;

            $totalKeluarBarang = $transaksi->sum('jumlah');
            $hariAktif         = $transaksi->pluck('tanggal_keluar')->unique()->count();
            $rataRataPerHari   = $hariAktif > 0 ? $totalKeluarBarang / $hariAktif : 0;
            $hariTersisa       = $rataRataPerHari > 0 ? round($barang->stok / $rataRataPerHari) : 999;
            $saranRestock      = ceil($rataRataPerHari * 30);

            if ($hariTersisa <= 30 && $rataRataPerHari > 0) {
                $prediksi[] = [
                    'barang'        => $barang,
                    'rata_rata'     => round($rataRataPerHari, 2),
                    'hari_tersisa'  => $hariTersisa,
                    'saran_restock' => $saranRestock,
                    'urgensi'       => $hariTersisa <= 7 ? 'kritis' : ($hariTersisa <= 15 ? 'menipis' : 'normal'),
                ];
            }
        }

        usort($prediksi, fn($a, $b) => $a['hari_tersisa'] <=> $b['hari_tersisa']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('prediksi.pdf', compact('prediksi'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('prediksi-restock-' . now()->format('Y-m-d') . '.pdf');
    }
}