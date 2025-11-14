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
        Schema::create('rawat_jalan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            $table->foreignId('dokter_id')->nullable()->constrained('dokter')->nullOnDelete();
            $table->foreignId('poli_id')->nullable()->constrained('polis')->nullOnDelete();
            $table->dateTime('tanggal_kunjungan');
            $table->text('keluhan');
            $table->text('diagnosa')->nullable();
            $table->text('tindakan')->nullable();
            $table->text('resep_obat')->nullable();
            $table->enum('status', ['Menunggu', 'Sedang Diperiksa', 'Selesai', 'Batal'])->default('Menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rawat_jalan');
    }
};
