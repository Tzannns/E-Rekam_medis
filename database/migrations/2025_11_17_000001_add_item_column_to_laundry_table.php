<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laundry', function (Blueprint $table) {
            if (!Schema::hasColumn('laundry', 'item')) {
                $table->string('item')->after('unit');
            }
        });
    }

    public function down(): void
    {
        Schema::table('laundry', function (Blueprint $table) {
            if (Schema::hasColumn('laundry', 'item')) {
                $table->dropColumn('item');
            }
        });
    }
};