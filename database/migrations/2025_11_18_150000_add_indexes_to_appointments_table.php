<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Tambah index untuk query yang sering digunakan
            $table->index(['jadwal_id', 'status'], 'idx_jadwal_status');
            $table->index(['pasien_id', 'status'], 'idx_pasien_status');
            $table->index(['tanggal_usulan', 'status'], 'idx_tanggal_status');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex('idx_jadwal_status');
            $table->dropIndex('idx_pasien_status');
            $table->dropIndex('idx_tanggal_status');
        });
    }
};
