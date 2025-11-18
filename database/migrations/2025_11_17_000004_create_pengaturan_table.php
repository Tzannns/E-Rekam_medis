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
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aplikasi')->default('E-Rekam Medis');
            $table->string('nama_instansi')->nullable();
            $table->text('alamat_instansi')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('timezone')->default('Asia/Jakarta');
            $table->string('bahasa')->default('id');
            $table->string('tema')->default('light');
            $table->integer('items_per_page')->default(15);
            $table->boolean('maintenance_mode')->default(false);
            $table->text('maintenance_message')->nullable();
            $table->boolean('registrasi_pasien')->default(true);
            $table->boolean('antrian_online')->default(true);
            $table->timestamps();
        });

        // Insert default settings
        DB::table('pengaturan')->insert([
            'nama_aplikasi' => 'E-Rekam Medis',
            'nama_instansi' => 'Rumah Sakit',
            'alamat_instansi' => 'Jl. Contoh No. 123',
            'no_telp' => '021-12345678',
            'email' => 'info@rumahsakit.com',
            'timezone' => 'Asia/Jakarta',
            'bahasa' => 'id',
            'tema' => 'light',
            'items_per_page' => 15,
            'maintenance_mode' => false,
            'registrasi_pasien' => true,
            'antrian_online' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};
