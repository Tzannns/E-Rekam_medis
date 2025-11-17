<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KasirPembayaran extends Model
{
    use HasFactory;

    protected $table = 'kasir_pembayaran';

    protected $fillable = [
        'transaksi_id',
        'tanggal',
        'metode',
        'jumlah',
        'referensi',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'jumlah' => 'decimal:2',
    ];

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(KasirTransaksi::class, 'transaksi_id');
    }
}