<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

use App\Http\Controllers\Api\BarangApiController;
use App\Http\Controllers\Api\BarangMasukApiController;
use App\Http\Controllers\Api\BarangKeluarApiController;
use App\Http\Controllers\Api\NotificationApiController;
use App\Http\Controllers\Api\AiAssistantController;   // ← TAMBAHAN BARU
use App\Http\Controllers\Api\LaporanApiController;

use App\Models\Barang;
use App\Models\User;


// ============================================================
// ===== API USER ==============================================
// ============================================================

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// ============================================================
// ===== API MASTER BARANG =====================================
// ============================================================

Route::get('/barang', [BarangApiController::class, 'index']);
Route::post('/barang', [BarangApiController::class, 'store']);
Route::get('/barang/{id}', [BarangApiController::class, 'show']);
Route::put('/barang/{id}', [BarangApiController::class, 'update']);
Route::delete('/barang/{id}', [BarangApiController::class, 'destroy']);


// ============================================================
// ===== API BARANG MASUK ======================================
// ============================================================

Route::get('/barang-masuk', [BarangMasukApiController::class, 'index']);
Route::post('/barang-masuk', [BarangMasukApiController::class, 'store']);
Route::get('/barang-masuk/{id}', [BarangMasukApiController::class, 'show']);
Route::put('/barang-masuk/{id}', [BarangMasukApiController::class, 'update']);
Route::delete('/barang-masuk/{id}', [BarangMasukApiController::class, 'destroy']);


// ============================================================
// ===== API BARANG KELUAR =====================================
// ============================================================

Route::get('/barang-keluar', [BarangKeluarApiController::class, 'index']);
Route::post('/barang-keluar', [BarangKeluarApiController::class, 'store']);
Route::get('/barang-keluar/{id}', [BarangKeluarApiController::class, 'show']);
Route::put('/barang-keluar/{id}', [BarangKeluarApiController::class, 'update']);
Route::delete('/barang-keluar/{id}', [BarangKeluarApiController::class, 'destroy']);


// ============================================================
// ===== API DASHBOARD STATS ===================================
// ============================================================

Route::get('/dashboard-stats', function () {

    // ✅ PAKE Soft Delete (deleted_at = NULL)
    $barangs = DB::table('barangs')
        ->get();

    return response()->json([
        'total_barang' => $barangs->count(),
        'total_stok' => $barangs->sum('stok'),
        'stok_menipis' => $barangs->whereBetween('stok', [5, 10])->count(),
        'stok_kritis' => $barangs->where('stok', '<', 5)->count(),
    ]);
});


// ============================================================
// ===== API LIST BARANG UNTUK MOBILE ==========================
// ============================================================

Route::get('/listbarang', function () {

    $data = DB::table('listbarang')->get();

    return response()->json([
        'success' => true,
        'data' => $data
    ]);
});


// ============================================================
// ===== API LOGIN =============================================
// ============================================================

Route::post('/login', function (Request $request) {

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {

        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }

    $token = $user->createToken('mobile-token')->plainTextToken;

    return response()->json([
        'success' => true,
        'token' => $token,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]
    ]);
});


// ============================================================
// ===== API LUPA PASSWORD =====================================
// ============================================================

Route::post('/forgot-password', function (Request $request) {

    $request->validate([
        'email' => 'required|email'
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    if ($status === Password::RESET_LINK_SENT) {

        return response()->json([
            'success' => true,
            'message' => 'Link reset password telah dikirim ke email Anda.'
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Email tidak ditemukan atau terjadi kesalahan.'
    ], 400);
});


// ============================================================
// ===== API PROFILE ===========================================
// ============================================================

Route::middleware('auth:sanctum')->group(function () {

    // GET PROFILE
    Route::get('/profile', function (Request $request) {

        return response()->json([
            'success' => true,
            'user' => $request->user()
        ]);
    });


    // UPDATE PROFILE
    Route::put('/profile', function (Request $request) {

        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->update([
            'name' => $request->name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated',
            'user' => $user
        ]);
    });


    // UPDATE PASSWORD
    Route::put('/password', function (Request $request) {

        $user = $request->user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check(
            $request->current_password,
            $user->password
        )) {

            return response()->json([
                'success' => false,
                'message' => 'Password lama salah'
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah'
        ]);
    });
});


// ============================================================
// ===== API LOGOUT ============================================
// ============================================================

Route::post('/logout', function (Request $request) {

    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'success' => true,
        'message' => 'Logout berhasil'
    ]);

})->middleware('auth:sanctum');


// ============================================================
// ===== NOTIFIKASI API ========================================
// ============================================================

Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationApiController::class, 'index']);
    Route::get('/unread-count', [NotificationApiController::class, 'unreadCount']);
    Route::post('/{id}/read', [NotificationApiController::class, 'markAsRead']);
    Route::post('/read-all', [NotificationApiController::class, 'markAllAsRead']);
    Route::delete('/{id}', [NotificationApiController::class, 'destroy']);
});


// ============================================================
// ===== AI ASSISTANT (GEMINI) =================================
// ============================================================

Route::post('/ai/chat', [AiAssistantController::class, 'chat']);

Route::get('/laporan', [LaporanApiController::class, 'index']);