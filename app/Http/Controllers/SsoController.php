<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\User;

class SsoController extends Controller
{
    /**
     * ===== REDIRECT KE WEB 2 DENGAN TOKEN =====
     */
    public function redirect(Request $request)
    {
        // Cek user udah login di Web 1?
        if (!Auth::check()) {
            // Belum login → ke halaman login Web 1
            return redirect()->route('login', ['redirect' => 'sso']);
        }

        // Bikin token unik (64 karakter random)
        $token = Str::random(64);

        // Simpan token di cache (expired 5 menit)
        Cache::put('sso_token_' . $token, Auth::id(), now()->addMinutes(5));

        // ✅ PAKE ENV
        $web2Url = env('WEB2_URL');

        return redirect($web2Url . '/sso-callback?token=' . $token);
    }

    /**
     * ===== VERIFY TOKEN =====
     */
    public function verify(Request $request)
    {
        $token = $request->get('token');

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak ada'
            ], 400);
        }

        // Cek token di cache
        $userId = Cache::get('sso_token_' . $token);

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid atau sudah expired'
            ], 401);
        }

        // Hapus token (sekali pake aja)
        Cache::forget('sso_token_' . $token);

        // Ambil data user
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role ?? 'staff',
            ]
        ]);
    }
}