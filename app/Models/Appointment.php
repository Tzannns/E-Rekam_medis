<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'poli_id',
        'dokter_id',
        'tanggal_usulan',
        'jam_usulan',
        'keluhan',
        'status',
        'catatan_admin',
        'jadwal_id',
        'nomor_antrian',
    ];

    protected $casts = [
        'tanggal_usulan' => 'date',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class);
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class);
    }
}
