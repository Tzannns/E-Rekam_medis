<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->foreignId('poli_id')->constrained('polis')->onDelete('cascade');
            $table->foreignId('dokter_id')->nullable()->constrained('dokter')->onDelete('cascade');
            $table->date('tanggal_usulan');
            $table->string('jam_usulan');
            $table->text('keluhan')->nullable();
            $table->enum('status', ['Menunggu', 'Disetujui', 'Diproses', 'Dibatalkan'])->default('Menunggu');
            $table->text('catatan_admin')->nullable();
            $table->foreignId('jadwal_id')->nullable()->constrained('jadwal')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
