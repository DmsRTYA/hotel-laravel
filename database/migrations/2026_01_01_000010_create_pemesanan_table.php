<?php

// ============================================================
// FILE    : database/migrations/xxxx_create_pemesanan_table.php
// PERINTAH: php artisan make:model Pemesanan -m
//           (otomatis membuat file ini)
// JALANKAN: php artisan migrate
// ============================================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tamu', 100);
            $table->string('email', 100);
            $table->string('no_telepon', 20);
            $table->string('no_identitas', 30);
            $table->string('jenis_kamar', 50);
            $table->integer('jumlah_kamar')->default(1);
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar');
            $table->integer('jumlah_tamu')->default(1);
            $table->text('permintaan')->nullable();
            $table->enum('status', [
                'Booking',
                'Dikonfirmasi',
                'Check-in',
                'Check-out',
                'Dibatalkan',
            ])->default('Booking');
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
