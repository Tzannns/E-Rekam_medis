<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('laundry')) {
            return;
        }

        Schema::create('laundry', function (Blueprint $table) {
            $table->id();
            $table->string('unit');
            $table->string('item');
            $table->unsignedInteger('jumlah');
            $table->dateTime('tanggal_masuk');
            $table->string('status')->default('Menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laundry');
    }
};
