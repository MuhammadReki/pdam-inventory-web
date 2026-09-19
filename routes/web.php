<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangListController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\SsoController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanExportController;
use App\Http\Controllers\PrediksiController;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ============================================================
// ===== SSO ROUTE (DI LUAR AUTH) =====
// ============================================================

Route::get('/sso/redirect', [SsoController::class, 'redirect'])
    ->name('sso.redirect');

Route::get('/sso/verify', [SsoController::class, 'verify'])
    ->name('sso.verify');

// ============================================================
// ===== HALAMAN UTAMA =====
// ============================================================

Route::get('/', function () {
    return redirect()->route('login');
});

// ============================================================
// ===== GANTI BAHASA =====
// ============================================================

Route::post('/locale', function (\Illuminate\Http\Request $request) {

    $locale = $request->input('locale', 'id');

    if (!in_array($locale, ['id', 'en'])) {
        $locale = 'id';
    }

    Session::put('locale', $locale);

    return redirect()->back();

})->name('locale.switch');

// ============================================================
// ===== SEMUA ROUTE YANG BUTUH LOGIN + ROLE =====
// ===== ADMIN & STAFF AJA =====
// ============================================================

Route::middleware(['auth', 'verified', 'role:admin,staff'])->group(function () {

    // ========================================================
    // DASHBOARD
    // ========================================================

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ========================================================
    // PROFILE
    // ========================================================

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // ========================================================
    // MASTER BARANG
    // ========================================================

    Route::resource('barang', BarangController::class);

    Route::resource('barang-masuk', BarangMasukController::class);

    Route::resource('barang-keluar', BarangKeluarController::class);

    Route::get('/barang-list', [BarangListController::class, 'index'])
        ->name('barang-list');

    // ========================================================
    // LAPORAN / EXPORT
    // ========================================================

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export/pdf', [LaporanExportController::class, 'exportPdf'])
        ->name('laporan.export.pdf');

    Route::get('/laporan/export/excel', [LaporanExportController::class, 'exportExcel'])
        ->name('laporan.export.excel');

    // ========================================================
    // PREDIKSI RESTOCK (AI)
    // ========================================================

    Route::get('/prediksi-restock', [PrediksiController::class, 'index'])
        ->name('prediksi.index');

    Route::get('/prediksi-restock/export-pdf', [PrediksiController::class, 'exportPdf'])
        ->name('prediksi.export.pdf');

    // ========================================================
    // NOTIFIKASI
    // ========================================================

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::get('/notifications/latest', [NotificationController::class, 'latest'])
        ->name('notifications.latest');

    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.read-all');

    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy');
});

// ============================================================
// ===== AUTH ROUTES =====
// ============================================================

require __DIR__.'/auth.php';