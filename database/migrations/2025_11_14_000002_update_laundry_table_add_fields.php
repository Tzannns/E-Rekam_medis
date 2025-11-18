<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laundry', function (Blueprint $table) {
            if (! Schema::hasColumn('laundry', 'jenis')) {
                $table->string('jenis')->nullable();
            }
            if (! Schema::hasColumn('laundry', 'berat_kg')) {
                $table->decimal('berat_kg', 8, 2)->nullable();
            }
            if (! Schema::hasColumn('laundry', 'tanggal_selesai')) {
                $table->dateTime('tanggal_selesai')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('laundry', function (Blueprint $table) {
            if (Schema::hasColumn('laundry', 'jenis')) {
                $table->dropColumn('jenis');
            }
            if (Schema::hasColumn('laundry', 'berat_kg')) {
                $table->dropColumn('berat_kg');
            }
            if (Schema::hasColumn('laundry', 'tanggal_selesai')) {
                $table->dropColumn('tanggal_selesai');
            }
        });
    }
};
