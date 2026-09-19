<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // ✅ TAMBAHKAN INI

class BarangApiController extends Controller
{
    /**
     * GET semua barang
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Barang::all()
        ]);
    }

    /**
     * GET detail barang berdasarkan ID
     */
    public function show($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $barang
        ]);
    }

    /**
     * POST tambah barang
     * ✅ SEJALAN: Simpan ke barangs DAN listbarang
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs',
            'nama_barang' => 'required',
            'satuan' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);

        // ✅ 1. SIMPAN KE TABEL 'barangs'
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

        // ✅ 2. JUGA SIMPAN KE TABEL 'listbarang' (SEJALAN)
        DB::table('listbarang')->insert([
            'id' => $barang->id,
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

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil ditambahkan!',
            'data' => $barang
        ], 201);
    }

    /**
     * PUT update barang
     * ✅ SEJALAN: Update ke barangs DAN listbarang
     */
    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $id,
            'nama_barang' => 'required',
            'satuan' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);

        // ✅ 1. UPDATE DI TABEL 'barangs'
        $barang->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'stok_awal' => $request->stok,
            'stok_akhir' => $request->stok,
        ]);

        // ✅ 2. JUGA UPDATE DI TABEL 'listbarang' (SEJALAN)
        DB::table('listbarang')
            ->where('id', $id)
            ->update([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'satuan' => $request->satuan,
                'harga' => $request->harga,
                'stok_awal' => $request->stok,
                'stok_akhir' => $request->stok,
                'updated_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil diupdate!',
            'data' => $barang
        ]);
    }

    /**
     * DELETE hapus barang
     * ✅ SEJALAN: Hapus dari barangs DAN listbarang
     */
    public function destroy($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        // ✅ 1. HAPUS DARI TABEL 'barangs'
        $barang->delete();

        // ✅ 2. JUGA HAPUS DARI TABEL 'listbarang' (SEJALAN)
        DB::table('listbarang')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil dihapus!'
        ]);
    }
}