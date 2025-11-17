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
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apotik_id')->constrained('apotiks')->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
            $table->string('kode_obat')->unique();
            $table->string('nama_obat');
            $table->string('kategori'); // Tablet, Kapsul, Sirup, Salep, dll
            $table->string('satuan'); // Box, Strip, Botol, Tube, dll
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_beli', 12, 2);
            $table->decimal('harga_jual', 12, 2);
            $table->integer('stok')->default(0);
            $table->integer('stok_minimum')->default(10);
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->string('no_batch')->nullable();
            $table->enum('status', ['Tersedia', 'Habis', 'Kadaluarsa'])->default('Tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
