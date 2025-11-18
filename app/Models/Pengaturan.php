<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    protected $table = 'pengaturan';

    protected $fillable = [
        'nama_aplikasi',
        'nama_instansi',
        'alamat_instansi',
        'no_telp',
        'email',
        'logo',
        'favicon',
        'timezone',
        'bahasa',
        'tema',
        'items_per_page',
        'maintenance_mode',
        'maintenance_message',
        'registrasi_pasien',
        'antrian_online',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
        'registrasi_pasien' => 'boolean',
        'antrian_online' => 'boolean',
        'items_per_page' => 'integer',
    ];

    /**
     * Get the singleton instance of settings
     */
    public static function getSettings()
    {
        return self::first() ?? self::createDefaultSettings();
    }

    /**
     * Create default settings
     */
    public static function createDefaultSettings()
    {
        return self::create([
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
        ]);
    }

    /**
     * Update settings
     */
    public static function updateSettings(array $data)
    {
        $settings = self::getSettings();
        $settings->update($data);

        return $settings;
    }
}
