<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class BarangKeluarApiController extends Controller
{
    public function index()
    {
        $data = BarangKeluar::with('barang')->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
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
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi! Stok tersisa: ' . $barang->stok
            ], 400);
        }

        $barang->stok -= $request->jumlah;
        $barang->save();

        $data = BarangKeluar::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Barang keluar berhasil ditambahkan',
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $data = BarangKeluar::with('barang')->find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = BarangKeluar::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'nullable'
        ]);

        // Kembalikan stok lama
        $barangLama = Barang::find($data->barang_id);
        $barangLama->stok += $data->jumlah;
        $barangLama->save();

        // Kurangi stok baru
        $barangBaru = Barang::find($request->barang_id);
        
        if ($barangBaru->stok < $request->jumlah) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi! Stok tersisa: ' . $barangBaru->stok
            ], 400);
        }

        $barangBaru->stok -= $request->jumlah;
        $barangBaru->save();

        $data->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Barang keluar berhasil diupdate',
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        $data = BarangKeluar::find($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        // Kembalikan stok
        $barang = Barang::find($data->barang_id);
        $barang->stok += $data->jumlah;
        $barang->save();

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang keluar berhasil dihapus'
        ]);
    }
}