<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $barangs = Barang::when($search, function ($query) use ($search) {
            return $query->where('nama_barang', 'LIKE', '%' . $search . '%')
                         ->orWhere('kode_barang', 'LIKE', '%' . $search . '%');
        })->get();

        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs',
            'nama_barang' => 'required',
            'satuan' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);

        $barang = Barang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'stok_awal' => $request->stok,
            'stok_akhir' => $request->stok,
            'total_masuk' => 0,
        ]);

        DB::table('listbarang')->insert([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'stok_awal' => $request->stok,
            'stok_akhir' => $request->stok,
            'total_masuk' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        NotificationService::barangBaru($barang);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang' => 'required',
            'satuan' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);

        $barang->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'stok_awal' => $request->stok,
            'stok_akhir' => $request->stok,
        ]);

        DB::table('listbarang')
            ->where('id', $barang->id)
            ->update([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'satuan' => $request->satuan,
                'harga' => $request->harga,
                'stok_awal' => $request->stok,
                'stok_akhir' => $request->stok,
                'updated_at' => now(),
            ]);

        NotificationService::barangEdit($barang);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil diupdate!');
    }

    public function destroy(Barang $barang)
    {
        $namaBarang = $barang->nama_barang;
        $barangId = $barang->id;

        $barang->delete();

        DB::table('listbarang')->where('id', $barang->id)->delete();

        NotificationService::barangHapus($namaBarang, $barangId);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil dihapus!');
    }
}