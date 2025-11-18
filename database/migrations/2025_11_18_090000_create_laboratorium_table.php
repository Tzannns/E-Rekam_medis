<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laboratorium', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('dokter')->onDelete('cascade');
            $table->string('jenis_pemeriksaan');
            $table->text('hasil')->nullable();
            $table->string('nilai_rujukan')->nullable();
            $table->string('satuan')->nullable();
            $table->dateTime('tanggal_periksa');
            $table->string('status')->default('Diajukan');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laboratorium');
    }
};
