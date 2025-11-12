<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('igd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            $table->foreignId('dokter_id')->nullable()->constrained('dokter')->nullOnDelete();
            $table->dateTime('tanggal_masuk');
            $table->dateTime('tanggal_keluar')->nullable();
            $table->text('keluhan_utama');
            $table->enum('triase_level', ['Hijau', 'Kuning', 'Merah', 'Hitam'])->default('Hijau');
            $table->enum('status', ['Menunggu', 'Sedang Ditangani', 'Selesai', 'Dirujuk'])->default('Menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('igd');
    }
};
