<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->string('no_telp', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set default values before making NOT NULL
        DB::table('pasien')->whereNull('no_telp')->update(['no_telp' => '']);

        Schema::table('pasien', function (Blueprint $table) {
            $table->string('no_telp', 20)->change();
        });
    }
};
