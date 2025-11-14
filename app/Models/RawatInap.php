<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RawatInap extends Model
{
    use HasFactory;

    protected $table = 'rawat_inap';

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'tanggal_masuk',
        'tanggal_keluar',
        'ruang',
        'no_tempat_tidur',
        'diagnosa',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_masuk' => 'date',
            'tanggal_keluar' => 'date',
        ];
    }

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class);
    }
}
