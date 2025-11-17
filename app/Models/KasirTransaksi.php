<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KasirTransaksi extends Model
{
    use HasFactory;

    protected $table = 'kasir_transaksi';

    protected $fillable = [
        'pasien_id',
        'nomor_invoice',
        'tanggal',
        'subtotal',
        'diskon',
        'total',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'subtotal' => 'decimal:2',
        'diskon' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(KasirTransaksiItem::class, 'transaksi_id');
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(KasirPembayaran::class, 'transaksi_id');
    }
}