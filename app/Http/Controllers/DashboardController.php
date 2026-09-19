<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)  // <== TAMBAH $request
    {
        $search = $request->get('search');
        
        // Ambil semua data barang dengan filter search
        $barangs = Barang::when($search, function ($query) use ($search) {
            return $query->where('nama_barang', 'LIKE', '%' . $search . '%')
                         ->orWhere('kode_barang', 'LIKE', '%' . $search . '%');
        })->get();

        // Hitung statistik (tetap dari semua data, bukan hasil filter)
        $totalBarang = Barang::count();
        $totalStok = Barang::sum('stok');
        $stokMenipis = Barang::whereBetween('stok', [5, 10])->count();
        $stokKritis = Barang::where('stok', '<', 5)->count();

        // Kirim data ke halaman dashboard
        return view('dashboard', compact(
            'barangs',
            'totalBarang',
            'totalStok',
            'stokMenipis',
            'stokKritis',
            'search'  // <== TAMBAH search
        ));
    }
}