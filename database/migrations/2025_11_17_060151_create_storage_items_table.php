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
        Schema::create('storage_items', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 50)->unique();
            $table->string('nama_barang', 255);
            $table->enum('kategori', ['Obat', 'Alat Medis', 'Consumable', 'Lainnya'])->default('Lainnya');
            $table->text('deskripsi')->nullable();
            $table->integer('stok_awal')->default(0);
            $table->integer('stok_saat_ini')->default(0);
            $table->integer('stok_minimal')->default(10);
            $table->string('satuan', 50);
            $table->decimal('harga_satuan', 12, 2)->default(0);
            $table->decimal('total_nilai', 15, 2)->default(0);
            $table->string('lokasi', 100)->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->enum('status', ['Aktif', 'Nonaktif', 'Kadaluarsa'])->default('Aktif');
            $table->string('supplier', 255)->nullable();
            $table->string('nomor_batch', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_items');
    }
};
