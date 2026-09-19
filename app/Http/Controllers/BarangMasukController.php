<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $barangMasuks = BarangMasuk::with('barang')
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('barang', function ($q) use ($search) {
                    $q->where('nama_barang', 'LIKE', '%' . $search . '%')
                      ->orWhere('kode_barang', 'LIKE', '%' . $search . '%');
                });
            })
            ->get();

        return view('barang_masuk.index', compact('barangMasuks'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('barang_masuk.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable'
        ]);

        $barang = Barang::find($request->barang_id);
        $barang->stok += $request->jumlah;
        $barang->save();

        $transaksi = BarangMasuk::create($request->all());

        NotificationService::barangMasuk($transaksi, $barang);

        return redirect()
            ->route('barang-masuk.index')
            ->with('success', 'Barang masuk berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(BarangMasuk $barangMasuk)
    {
        $barangs = Barang::all();
        return view('barang_masuk.edit', compact('barangMasuk', 'barangs'));
    }

    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable'
        ]);

        $barangLama = Barang::find($barangMasuk->barang_id);
        $barangLama->stok -= $barangMasuk->jumlah;
        $barangLama->save();

        $barangBaru = Barang::find($request->barang_id);
        $barangBaru->stok += $request->jumlah;
        $barangBaru->save();

        $barangMasuk->update($request->all());

        return redirect()
            ->route('barang-masuk.index')
            ->with('success', 'Barang masuk berhasil diupdate!');
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        $barang = Barang::find($barangMasuk->barang_id);
        $barang->stok -= $barangMasuk->jumlah;
        $barang->save();

        $barangMasuk->delete();

        return redirect()
            ->route('barang-masuk.index')
            ->with('success', 'Barang masuk berhasil dihapus!');
    }
}