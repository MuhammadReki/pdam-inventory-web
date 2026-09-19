<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $userRole = strtolower(trim(Auth::user()->role ?? 'staff'));

        // ===== PRIORITAS 1: PIMPINAN → LANGSUNG KE WEB 2 =====
        if ($userRole === 'pimpinan') {
            $token = Str::random(64);
            Cache::put('sso_token_' . $token, Auth::id(), now()->addMinutes(5));

            $web2Url = rtrim(env('WEB2_URL'), '/');
            return redirect($web2Url . '/sso-callback?token=' . $token);
        }

        // ===== PRIORITAS 2: LOGIN DARI SSO =====
        if ($request->redirect === 'sso') {
            return redirect()->route('sso.redirect');
        }

        // ===== PRIORITAS 3: ADMIN/STAFF → DASHBOARD WEB 1 =====
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}