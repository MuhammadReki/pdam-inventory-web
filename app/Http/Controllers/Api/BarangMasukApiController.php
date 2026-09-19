<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class BarangMasukApiController extends Controller
{
    /**
     * GET semua barang masuk
     */
    public function index()
    {
        $barangMasuks = BarangMasuk::with('barang')->get();

        return response()->json([
            'success' => true,
            'data' => $barangMasuks
        ]);
    }

    /**
     * GET detail barang masuk berdasarkan ID
     */
    public function show($id)
    {
        $barangMasuk = BarangMasuk::with('barang')->find($id);

        if (!$barangMasuk) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $barangMasuk
        ]);
    }

    /**
     * POST tambah barang masuk
     */
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable'
        ]);

        // Update stok barang otomatis
        $barang = Barang::find($request->barang_id);
        $barang->stok += $request->jumlah;
        $barang->save();

        $barangMasuk = BarangMasuk::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Barang masuk berhasil ditambahkan',
            'data' => $barangMasuk
        ], 201);
    }

    /**
     * PUT update barang masuk
     */
    public function update(Request $request, $id)
    {
        $barangMasuk = BarangMasuk::find($id);

        if (!$barangMasuk) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable'
        ]);

        // Kembalikan stok dari data lama
        $barangLama = Barang::find($barangMasuk->barang_id);
        $barangLama->stok -= $barangMasuk->jumlah;
        $barangLama->save();

        // Tambahkan stok berdasarkan data baru
        $barangBaru = Barang::find($request->barang_id);
        $barangBaru->stok += $request->jumlah;
        $barangBaru->save();

        // Update data barang masuk
        $barangMasuk->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Barang masuk berhasil diupdate',
            'data' => $barangMasuk
        ]);
    }

    /**
     * DELETE hapus barang masuk
     */
    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::find($id);

        if (!$barangMasuk) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Kurangi stok barang
        $barang = Barang::find($barangMasuk->barang_id);
        $barang->stok -= $barangMasuk->jumlah;
        $barang->save();

        // Hapus data barang masuk
        $barangMasuk->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang masuk berhasil dihapus'
        ]);
    }
}