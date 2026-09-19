<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil filter
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', now()->format('Y-m-d'));
        $jenis     = $request->input('jenis', 'semua');

        // 2. Ambil data
        $laporan = collect();

        // Barang Masuk
        if ($jenis === 'semua' || $jenis === 'masuk') {
            $masuk = BarangMasuk::with('barang')
                ->whereBetween('tanggal_masuk', [$startDate, $endDate])
                ->get();

            foreach ($masuk as $item) {
                $laporan->push([
                    'tanggal'    => $item->tanggal_masuk,
                    'kode'       => $item->barang->kode_barang ?? '-',
                    'nama'       => $item->barang->nama_barang ?? '-',
                    'jenis'      => 'Masuk',
                    'jumlah'     => $item->jumlah,
                    'keterangan' => $item->keterangan ?? '-',
                ]);
            }
        }

        // Barang Keluar
        if ($jenis === 'semua' || $jenis === 'keluar') {
            $keluar = BarangKeluar::with('barang')
                ->whereBetween('tanggal_keluar', [$startDate, $endDate])
                ->get();

            foreach ($keluar as $item) {
                $laporan->push([
                    'tanggal'    => $item->tanggal_keluar,
                    'kode'       => $item->barang->kode_barang ?? '-',
                    'nama'       => $item->barang->nama_barang ?? '-',
                    'jenis'      => 'Keluar',
                    'jumlah'     => $item->jumlah,
                    'keterangan' => $item->keterangan ?? '-',
                ]);
            }
        }

        // 3. Sort by tanggal
        $laporan = $laporan->sortByDesc('tanggal')->values();

        // 4. Hitung statistik
        $totalMasuk     = $laporan->where('jenis', 'Masuk')->sum('jumlah');
        $totalKeluar    = $laporan->where('jenis', 'Keluar')->sum('jumlah');
        $totalTransaksi = $laporan->count();

        // 5. Kirim ke view
        return view('laporan.index', compact(
            'laporan', 'startDate', 'endDate', 'jenis',
            'totalMasuk', 'totalKeluar', 'totalTransaksi'
        ));
    }
}