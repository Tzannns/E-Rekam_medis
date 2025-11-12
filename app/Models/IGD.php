<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IGD extends Model
{
    /** @use HasFactory<\Database\Factories\IGDFactory> */
    use HasFactory;

    protected $table = 'igd';

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'tanggal_masuk',
        'tanggal_keluar',
        'keluhan_utama',
        'triase_level',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tanggal_keluar' => 'datetime',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }
}
