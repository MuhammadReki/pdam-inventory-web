<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ✅ TAMBAHAN: Force HTTPS di production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        View::composer('layouts.app', function ($view) {
            $view->with('totalBarang', Barang::count());
            $view->with('totalMasuk', BarangMasuk::count());
            $view->with('totalKeluar', BarangKeluar::count());
        });
    }
}