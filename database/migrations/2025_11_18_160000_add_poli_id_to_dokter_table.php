<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dokter', function (Blueprint $table) {
            $table->foreignId('poli_id')->nullable()->after('nip')->constrained('polis')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('dokter', function (Blueprint $table) {
            $table->dropConstrainedForeignId('poli_id');
        });
    }
};
