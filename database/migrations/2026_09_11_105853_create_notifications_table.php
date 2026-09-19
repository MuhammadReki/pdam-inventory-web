<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            
            // Target penerima
            $table->unsignedBigInteger('user_id')->nullable();     // user spesifik (opsional)
            $table->string('role_target')->default('all');          // all / admin / staff / pimpinan
            
            // Isi notifikasi
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('info');                // info / success / warning / danger
            $table->string('category')->default('sistem');          // barang / stok / masuk / keluar / laporan / sistem
            $table->string('icon')->nullable();                     // emoji / nama icon
            
            // Referensi ke data terkait
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('reference_type')->nullable();           // Barang / BarangMasuk / BarangKeluar
            
            // Status
            $table->boolean('is_read')->default(false);
            $table->string('source')->default('system');            // web / mobile / system
            
            // Extra
            $table->string('action_url')->nullable();               // link navigasi
            $table->json('meta')->nullable();                       // data tambahan
            
            $table->timestamps();
            
            // Index buat query cepat
            $table->index(['source', 'is_read']);
            $table->index(['role_target', 'is_read']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};