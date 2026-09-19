<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class LaporanApiController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', now()->format('Y-m-d'));
        $jenis     = $request->input('jenis', 'semua');

        $laporan = collect();

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

        $laporan = $laporan->sortByDesc('tanggal')->values();

        return response()->json([
            'success'         => true,
            'laporan'         => $laporan,
            'total_transaksi' => $laporan->count(),
            'total_masuk'     => $laporan->where('jenis', 'Masuk')->sum('jumlah'),
            'total_keluar'    => $laporan->where('jenis', 'Keluar')->sum('jumlah'),
        ]);
    }
}