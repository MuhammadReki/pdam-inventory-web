<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanExportController extends Controller
{
    /**
     * Export laporan ke PDF
     */
    public function exportPdf(Request $request)
    {
        // 1. Ambil filter dari request
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', now()->format('Y-m-d'));
        $jenis     = $request->input('jenis', 'semua');

        // 2. Ambil data dari database
        $laporan = $this->getLaporanData($startDate, $endDate, $jenis);

        // 3. Hitung statistik
        $totalMasuk  = $laporan->where('jenis', 'Masuk')->sum('jumlah');
        $totalKeluar = $laporan->where('jenis', 'Keluar')->sum('jumlah');
        $totalTransaksi = $laporan->count();

        // 4. Bikin PDF
        $pdf = Pdf::loadView('laporan.pdf', [
            'laporan'        => $laporan,
            'startDate'      => $startDate,
            'endDate'        => $endDate,
            'jenis'          => $jenis,
            'totalMasuk'     => $totalMasuk,
            'totalKeluar'    => $totalKeluar,
            'totalTransaksi' => $totalTransaksi,
        ]);

        // 5. Set ukuran kertas
        $pdf->setPaper('A4', 'landscape');

        // 6. Download PDF
        $filename = 'laporan_' . $startDate . '_' . $endDate . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Export laporan ke Excel
     */
    public function exportExcel(Request $request)
    {
        // 1. Ambil filter
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', now()->format('Y-m-d'));
        $jenis     = $request->input('jenis', 'semua');

        // 2. Download Excel
        $filename = 'laporan_' . $startDate . '_' . $endDate . '.xlsx';
        return Excel::download(new LaporanExport($startDate, $endDate, $jenis), $filename);
    }

    /**
     * Ambil data laporan dari database
     */
    private function getLaporanData($startDate, $endDate, $jenis)
    {
        $data = collect();

        // Ambil barang masuk
        if ($jenis === 'semua' || $jenis === 'masuk') {
            $masuk = BarangMasuk::with('barang')
                ->whereBetween('tanggal_masuk', [$startDate, $endDate])
                ->orderBy('tanggal_masuk', 'desc')
                ->get();

            foreach ($masuk as $item) {
                $data->push([
                    'tanggal'    => $item->tanggal_masuk,
                    'kode'       => $item->barang->kode_barang ?? '-',
                    'nama'       => $item->barang->nama_barang ?? '-',
                    'jenis'      => 'Masuk',
                    'jumlah'     => $item->jumlah,
                    'keterangan' => $item->keterangan ?? '-',
                ]);
            }
        }

        // Ambil barang keluar
        if ($jenis === 'semua' || $jenis === 'keluar') {
            $keluar = BarangKeluar::with('barang')
                ->whereBetween('tanggal_keluar', [$startDate, $endDate])
                ->orderBy('tanggal_keluar', 'desc')
                ->get();

            foreach ($keluar as $item) {
                $data->push([
                    'tanggal'    => $item->tanggal_keluar,
                    'kode'       => $item->barang->kode_barang ?? '-',
                    'nama'       => $item->barang->nama_barang ?? '-',
                    'jenis'      => 'Keluar',
                    'jumlah'     => $item->jumlah,
                    'keterangan' => $item->keterangan ?? '-',
                ]);
            }
        }

        // Sort by tanggal
        return $data->sortByDesc('tanggal')->values();
    }
}