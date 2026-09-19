<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $barangKeluars = BarangKeluar::with('barang')
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('barang', function ($q) use ($search) {
                    $q->where('nama_barang', 'LIKE', '%' . $search . '%')
                      ->orWhere('kode_barang', 'LIKE', '%' . $search . '%');
                });
            })
            ->get();

        $totalKeluar = BarangKeluar::sum('jumlah');
        $totalBarang = Barang::count();
        $transaksiHariIni = BarangKeluar::whereDate('tanggal_keluar', Carbon::today())->count();
        $bulanIni = BarangKeluar::whereMonth('tanggal_keluar', Carbon::now()->month)
            ->whereYear('tanggal_keluar', Carbon::now()->year)
            ->sum('jumlah');

        return view('barang_keluar.index', compact(
            'barangKeluars',
            'totalKeluar',
            'totalBarang',
            'transaksiHariIni',
            'bulanIni'
        ));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('barang_keluar.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'nullable'
        ]);

        $barang = Barang::find($request->barang_id);
        
        if ($barang->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi! Stok tersisa: ' . $barang->stok);
        }

        $barang->stok -= $request->jumlah;
        $barang->save();

        $transaksi = BarangKeluar::create($request->all());

        NotificationService::barangKeluar($transaksi, $barang);
        NotificationService::checkStok($barang);

        return redirect()
            ->route('barang-keluar.index')
            ->with('success', 'Barang keluar berhasil ditambahkan!');
    }

    public function edit(BarangKeluar $barangKeluar)
    {
        $barangs = Barang::all();
        return view('barang_keluar.edit', compact('barangKeluar', 'barangs'));
    }

    public function update(Request $request, BarangKeluar $barangKeluar)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'nullable'
        ]);

        $barangLama = Barang::find($barangKeluar->barang_id);
        $barangLama->stok += $barangKeluar->jumlah;
        $barangLama->save();

        $barangBaru = Barang::find($request->barang_id);
        
        if ($barangBaru->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi! Stok tersisa: ' . $barangBaru->stok);
        }

        $barangBaru->stok -= $request->jumlah;
        $barangBaru->save();

        $barangKeluar->update($request->all());

        return redirect()
            ->route('barang-keluar.index')
            ->with('success', 'Barang keluar berhasil diupdate!');
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        $barang = Barang::find($barangKeluar->barang_id);
        $barang->stok += $barangKeluar->jumlah;
        $barang->save();

        $barangKeluar->delete();

        return redirect()
            ->route('barang-keluar.index')
            ->with('success', 'Barang keluar berhasil dihapus!');
    }
}