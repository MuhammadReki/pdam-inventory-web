<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangListController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        // ✅ AMBIL LANGSUNG DARI TABEL 'listbarang'
        $barangs = DB::table('listbarang')
            ->when($search, function ($query) use ($search) {
                return $query->where('nama_barang', 'LIKE', '%' . $search . '%')
                             ->orWhere('kode_barang', 'LIKE', '%' . $search . '%');
            })
            ->get();

        return view('barang-list', compact('barangs'));
    }
}