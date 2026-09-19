<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Gemini\Laravel\Facades\Gemini;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Notification;
use App\Models\User;

class AiAssistantController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        // Ambil user yang login (kalau ada)
        $user = $request->user();

        // Build konteks lengkap
        $context = $this->buildFullContext($user);

        // Bikin prompt
        $prompt = "Kamu adalah asisten inventory PDAM Tirta Sago. "
                . "Jawab dengan bahasa Indonesia santai dan singkat. "
                . "Kalau ditanya soal data, pakai DATA di bawah ini. "
                . "Kalau data nggak ada di konteks, bilang aja nggak tau.\n\n"
                . "=== DATA SISTEM INVENTORY ===\n"
                . $context . "\n"
                . "=== AKHIR DATA ===\n\n"
                . "Pertanyaan user: " . $request->message;

        // ✅ RETRY LOGIC: Coba sampai 3x kalau Gemini overload
        $maxRetries = 3;
        $attempt = 0;
        $lastError = null;

        while ($attempt < $maxRetries) {
            try {
                $result = Gemini::generativeModel(model: config('gemini.model'))
                    ->generateContent($prompt);

                return response()->json([
                    'success' => true,
                    'reply'   => $result->text(),
                ]);
            } catch (\Exception $e) {
                $lastError = $e;
                $attempt++;

                // Cek apakah error ini karena server rame/limit
                $isOverload = strpos($e->getMessage(), 'high demand') !== false
                           || strpos($e->getMessage(), 'UNAVAILABLE') !== false
                           || strpos($e->getMessage(), 'timed out') !== false
                           || strpos($e->getMessage(), '429') !== false
                           || strpos($e->getMessage(), '503') !== false;

                // Kalau bukan error overload, langsung lempar
                if (!$isOverload) {
                    break;
                }

                // Kasih jeda 5 detik sebelum coba lagi
                if ($attempt < $maxRetries) {
                    sleep(5);
                }
            }
        }

        // Semua retry gagal
        return response()->json([
            'success' => false,
            'error'   => 'AI sedang sibuk, coba lagi nanti.',
            'detail'  => $lastError ? $lastError->getMessage() : 'Unknown error',
        ], 500);
    }

    /**
     * Build konteks lengkap dari semua tabel
     */
    private function buildFullContext($user = null): string
    {
        $teks = "";

        // ============================================
        // 1. MASTER BARANG
        // ============================================
        $totalJenisBarang = Barang::count();
        $totalStok        = Barang::sum('stok');
        $totalNilaiAset   = Barang::sum(DB::raw('stok * harga'));

        $teks .= "--- MASTER BARANG ---\n";
        $teks .= "Total jenis barang: {$totalJenisBarang}\n";
        $teks .= "Total stok keseluruhan: {$totalStok} unit\n";
        $teks .= "Total nilai aset: Rp " . number_format($totalNilaiAset, 0, ',', '.') . "\n\n";

        // Barang stok kritis (< 5)
        $barangKritis = Barang::where('stok', '<', 5)
            ->orderBy('stok', 'asc')
            ->limit(10)
            ->get(['nama_barang', 'stok', 'satuan']);

        if ($barangKritis->count() > 0) {
            $teks .= "Barang STOK KRITIS (< 5):\n";
            foreach ($barangKritis as $b) {
                $teks .= "- {$b->nama_barang}: {$b->stok} {$b->satuan}\n";
            }
            $teks .= "\n";
        }

        // Barang stok menipis (5-10)
        $barangMenipis = Barang::whereBetween('stok', [5, 10])
            ->orderBy('stok', 'asc')
            ->limit(10)
            ->get(['nama_barang', 'stok', 'satuan']);

        if ($barangMenipis->count() > 0) {
            $teks .= "Barang STOK MENIPIS (5-10):\n";
            foreach ($barangMenipis as $b) {
                $teks .= "- {$b->nama_barang}: {$b->stok} {$b->satuan}\n";
            }
            $teks .= "\n";
        }

        // Top 10 barang stok terbanyak
        $topStok = Barang::orderBy('stok', 'desc')
            ->limit(10)
            ->get(['nama_barang', 'stok', 'satuan']);

        if ($topStok->count() > 0) {
            $teks .= "Top 10 barang stok TERBANYAK:\n";
            foreach ($topStok as $b) {
                $teks .= "- {$b->nama_barang}: {$b->stok} {$b->satuan}\n";
            }
            $teks .= "\n";
        }

        // ============================================
        // 2. BARANG MASUK
        // ============================================
        $bulanIni = now()->startOfMonth();
        $totalMasukBulanIni = BarangMasuk::where('tanggal_masuk', '>=', $bulanIni)->sum('jumlah');
        $jumlahTransaksiMasuk = BarangMasuk::where('tanggal_masuk', '>=', $bulanIni)->count();

        $teks .= "--- BARANG MASUK (BULAN INI) ---\n";
        $teks .= "Total transaksi masuk: {$jumlahTransaksiMasuk}\n";
        $teks .= "Total unit masuk: {$totalMasukBulanIni}\n\n";

        // 5 transaksi masuk terakhir
        $masukTerakhir = BarangMasuk::with('barang')
            ->orderBy('tanggal_masuk', 'desc')
            ->limit(5)
            ->get();

        if ($masukTerakhir->count() > 0) {
            $teks .= "5 transaksi masuk terakhir:\n";
            foreach ($masukTerakhir as $m) {
                $namaBarang = $m->barang->nama_barang ?? 'Barang #' . $m->barang_id;
                $teks .= "- {$m->tanggal_masuk}: {$namaBarang} sebanyak {$m->jumlah}\n";
            }
            $teks .= "\n";
        }

        // ============================================
        // 3. BARANG KELUAR
        // ============================================
        $totalKeluarBulanIni = BarangKeluar::where('tanggal_keluar', '>=', $bulanIni)->sum('jumlah');
        $jumlahTransaksiKeluar = BarangKeluar::where('tanggal_keluar', '>=', $bulanIni)->count();

        $teks .= "--- BARANG KELUAR (BULAN INI) ---\n";
        $teks .= "Total transaksi keluar: {$jumlahTransaksiKeluar}\n";
        $teks .= "Total unit keluar: {$totalKeluarBulanIni}\n\n";

        // 5 transaksi keluar terakhir
        $keluarTerakhir = BarangKeluar::with('barang')
            ->orderBy('tanggal_keluar', 'desc')
            ->limit(5)
            ->get();

        if ($keluarTerakhir->count() > 0) {
            $teks .= "5 transaksi keluar terakhir:\n";
            foreach ($keluarTerakhir as $k) {
                $namaBarang = $k->barang->nama_barang ?? 'Barang #' . $k->barang_id;
                $teks .= "- {$k->tanggal_keluar}: {$namaBarang} sebanyak {$k->jumlah}\n";
            }
            $teks .= "\n";
        }

        // Top 10 barang paling sering keluar (bulan ini)
        $topKeluar = BarangKeluar::select('barang_id', DB::raw('SUM(jumlah) as total_keluar'))
            ->where('tanggal_keluar', '>=', $bulanIni)
            ->groupBy('barang_id')
            ->orderBy('total_keluar', 'desc')
            ->limit(10)
            ->with('barang')
            ->get();

        if ($topKeluar->count() > 0) {
            $teks .= "Top 10 barang PALING SERING KELUAR (bulan ini):\n";
            foreach ($topKeluar as $t) {
                $namaBarang = $t->barang->nama_barang ?? 'Barang #' . $t->barang_id;
                $teks .= "- {$namaBarang}: {$t->total_keluar} unit\n";
            }
            $teks .= "\n";
        }

        // ============================================
        // 4. TREND 7 HARI TERAKHIR
        // ============================================
        $tujuhHariLalu = now()->subDays(7);

        $masuk7Hari = BarangMasuk::where('tanggal_masuk', '>=', $tujuhHariLalu)->sum('jumlah');
        $keluar7Hari = BarangKeluar::where('tanggal_keluar', '>=', $tujuhHariLalu)->sum('jumlah');

        $teks .= "--- TREND 7 HARI TERAKHIR ---\n";
        $teks .= "Total masuk: {$masuk7Hari} unit\n";
        $teks .= "Total keluar: {$keluar7Hari} unit\n\n";

        // ============================================
        // 5. DEAD STOCK (barang nggak pernah keluar)
        // ============================================
        $barangIdsYangPernahKeluar = BarangKeluar::distinct()->pluck('barang_id')->toArray();
        $deadStock = Barang::whereNotIn('id', $barangIdsYangPernahKeluar)
            ->limit(10)
            ->get(['nama_barang', 'stok', 'satuan']);

        if ($deadStock->count() > 0) {
            $teks .= "--- DEAD STOCK (belum pernah keluar) ---\n";
            foreach ($deadStock as $d) {
                $teks .= "- {$d->nama_barang}: {$d->stok} {$d->satuan}\n";
            }
            $teks .= "\n";
        }

        // ============================================
        // 6. NOTIFIKASI
        // ============================================
        $notifUnread = Notification::where('is_read', false)->count();
        $notifTotal  = Notification::count();

        $teks .= "--- NOTIFIKASI ---\n";
        $teks .= "Total notifikasi: {$notifTotal}\n";
        $teks .= "Belum dibaca: {$notifUnread}\n\n";

        $notifTerbaru = Notification::orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['title', 'message', 'created_at']);

        if ($notifTerbaru->count() > 0) {
            $teks .= "5 notifikasi terbaru:\n";
            foreach ($notifTerbaru as $n) {
                $teks .= "- {$n->title}: {$n->message}\n";
            }
            $teks .= "\n";
        }

        // ============================================
        // 7. USERS
        // ============================================
        $totalUser = User::count();
        $userByRole = User::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->get();

        $teks .= "--- USERS ---\n";
        $teks .= "Total user: {$totalUser}\n";
        foreach ($userByRole as $u) {
            $teks .= "- Role {$u->role}: {$u->total} user\n";
        }
        $teks .= "\n";

        // ============================================
        // 8. INFO USER YANG LAGI LOGIN
        // ============================================
        if ($user) {
            $teks .= "--- USER YANG SEDANG BERTANYA ---\n";
            $teks .= "Nama: {$user->name}\n";
            $teks .= "Role: {$user->role}\n";
        }

        return $teks;
    }
}