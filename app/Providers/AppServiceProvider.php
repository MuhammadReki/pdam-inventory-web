<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
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
        View::composer('layouts.app', function ($view) {
            $view->with('totalBarang', Barang::count());
            $view->with('totalMasuk', BarangMasuk::count());
            $view->with('totalKeluar', BarangKeluar::count());
        });
    }
}