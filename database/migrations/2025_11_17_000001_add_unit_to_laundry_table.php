<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('laundry')) {
            return;
        }

        Schema::table('laundry', function (Blueprint $table) {
            if (! Schema::hasColumn('laundry', 'unit')) {
                // make column nullable to avoid issues with existing rows
                $table->string('unit')->nullable()->after('id');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('laundry')) {
            return;
        }

        Schema::table('laundry', function (Blueprint $table) {
            if (Schema::hasColumn('laundry', 'unit')) {
                $table->dropColumn('unit');
            }
        });
    }
};
