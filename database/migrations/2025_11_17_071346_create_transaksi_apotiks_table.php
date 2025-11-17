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
        Schema::create('transaksi_apotiks', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique();
            $table->foreignId('apotik_id')->constrained('apotiks')->onDelete('cascade');
            $table->foreignId('pasien_id')->nullable()->constrained('pasien')->onDelete('set null');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Kasir/Petugas
            $table->foreignId('rekam_medis_id')->nullable()->constrained('rekam_medis')->onDelete('set null');
            $table->string('nama_pembeli')->nullable(); // Jika bukan pasien terdaftar
            $table->enum('tipe_pembeli', ['Pasien', 'Umum'])->default('Umum');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('diskon', 12, 2)->default(0);
            $table->decimal('pajak', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->decimal('bayar', 12, 2);
            $table->decimal('kembalian', 12, 2);
            $table->enum('metode_pembayaran', ['Tunai', 'Debit', 'Kredit', 'Transfer', 'BPJS'])->default('Tunai');
            $table->enum('status', ['Selesai', 'Pending', 'Batal'])->default('Selesai');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_apotiks');
    }
};
