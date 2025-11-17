<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kasir_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('kasir_transaksi')->cascadeOnDelete();
            $table->dateTime('tanggal');
            $table->enum('metode', ['Tunai', 'Kartu', 'Transfer', 'BPJS']);
            $table->decimal('jumlah', 12, 2);
            $table->string('referensi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kasir_pembayaran');
    }
};