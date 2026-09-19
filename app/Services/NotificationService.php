<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    /**
     * Kirim notifikasi umum
     */
    public static function send(array $data)
    {
        return Notification::create([
            'user_id'         => $data['user_id'] ?? null,
            'role_target'     => $data['role_target'] ?? 'all',
            'title'           => $data['title'],
            'message'         => $data['message'],
            'type'            => $data['type'] ?? 'info',
            'category'        => $data['category'] ?? 'sistem',
            'icon'            => $data['icon'] ?? null,
            'reference_id'    => $data['reference_id'] ?? null,
            'reference_type'  => $data['reference_type'] ?? null,
            'source'          => $data['source'] ?? self::detectSource(),
            'action_url'      => $data['action_url'] ?? null,
            'meta'            => $data['meta'] ?? null,
        ]);
    }

    /**
     * Auto-detect sumber notif (web / mobile / system)
     */
    private static function detectSource(): string
    {
        $request = request();

        if (!$request) {
            return 'system';
        }

        if (str_starts_with($request->path(), 'api/')) {
            return 'mobile';
        }

        if (Auth::check()) {
            return 'web';
        }

        return 'system';
    }

    // ===== HELPER SPESIFIK =====

    public static function barangBaru($barang, $source = null)
    {
        return self::send([
            'title'          => 'Barang Baru Ditambahkan',
            'message'        => "{$barang->nama_barang} berhasil ditambahkan",
            'type'           => 'success',
            'category'       => 'barang',
            'icon'           => '📦',
            'reference_id'   => $barang->id,
            'reference_type' => 'Barang',
            'source'         => $source ?? self::detectSource(),
        ]);
    }

    public static function barangEdit($barang, $source = null)
    {
        return self::send([
            'title'          => 'Barang Diedit',
            'message'        => "{$barang->nama_barang} berhasil diubah",
            'type'           => 'info',
            'category'       => 'barang',
            'icon'           => '✏️',
            'reference_id'   => $barang->id,
            'reference_type' => 'Barang',
            'source'         => $source ?? self::detectSource(),
        ]);
    }

    public static function barangHapus($namaBarang, $id, $source = null)
    {
        return self::send([
            'title'          => 'Barang Dihapus',
            'message'        => "{$namaBarang} telah dihapus dari sistem",
            'type'           => 'warning',
            'category'       => 'barang',
            'icon'           => '🗑️',
            'reference_id'   => $id,
            'reference_type' => 'Barang',
            'source'         => $source ?? self::detectSource(),
        ]);
    }

    public static function barangMasuk($transaksi, $barang, $source = null)
    {
        return self::send([
            'title'          => 'Barang Masuk',
            'message'        => "{$barang->nama_barang} masuk {$transaksi->jumlah} unit",
            'type'           => 'success',
            'category'       => 'masuk',
            'icon'           => '⬇️',
            'reference_id'   => $transaksi->id,
            'reference_type' => 'BarangMasuk',
            'source'         => $source ?? self::detectSource(),
        ]);
    }

    public static function barangKeluar($transaksi, $barang, $source = null)
    {
        return self::send([
            'title'          => 'Barang Keluar',
            'message'        => "{$barang->nama_barang} keluar {$transaksi->jumlah} unit",
            'type'           => 'info',
            'category'       => 'keluar',
            'icon'           => '⬆️',
            'reference_id'   => $transaksi->id,
            'reference_type' => 'BarangKeluar',
            'source'         => $source ?? self::detectSource(),
        ]);
    }

    public static function stokMenipis($barang)
    {
        return self::send([
            'title'          => '⚠️ Stok Menipis',
            'message'        => "{$barang->nama_barang} tersisa {$barang->stok} unit",
            'type'           => 'warning',
            'category'       => 'stok',
            'icon'           => '⚠️',
            'reference_id'   => $barang->id,
            'reference_type' => 'Barang',
            'source'         => 'system',
        ]);
    }

    public static function stokKritis($barang)
    {
        return self::send([
            'title'          => '🚨 Stok Kritis!',
            'message'        => "{$barang->nama_barang} tersisa {$barang->stok} unit. Segera restock!",
            'type'           => 'danger',
            'category'       => 'stok',
            'icon'           => '🚨',
            'reference_id'   => $barang->id,
            'reference_type' => 'Barang',
            'source'         => 'system',
        ]);
    }

    /**
     * Cek stok otomatis
     */
    public static function checkStok($barang, $batasMenipis = 10, $batasKritis = 5)
    {
        if ($barang->stok < $batasKritis) {
            self::stokKritis($barang);
        } elseif ($barang->stok < $batasMenipis) {
            self::stokMenipis($barang);
        }
    }
}