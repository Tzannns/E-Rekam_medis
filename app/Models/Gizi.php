<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gizi extends Model
{
    use HasFactory;

    protected $table = 'gizi';

    protected $fillable = [
        'pasien_id',
        'tanggal',
        'jenis_makanan',
        'jumlah',
        'catatan',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}