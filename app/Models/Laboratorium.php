<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laboratorium extends Model
{
    use HasFactory;

    protected $table = 'laboratorium';

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'jenis_pemeriksaan',
        'hasil',
        'nilai_rujukan',
        'satuan',
        'tanggal_periksa',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_periksa' => 'datetime',
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
