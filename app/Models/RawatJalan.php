<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RawatJalan extends Model
{
    use HasFactory;

    protected $table = 'rawat_jalan';

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'poli_id',
        'tanggal_kunjungan',
        'keluhan',
        'diagnosa',
        'tindakan',
        'resep_obat',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kunjungan' => 'datetime',
        ];
    }

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }
}
