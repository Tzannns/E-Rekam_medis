<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KasirTransaksiItem extends Model
{
    use HasFactory;

    protected $table = 'kasir_transaksi_items';

    protected $fillable = [
        'transaksi_id',
        'deskripsi',
        'qty',
        'harga',
        'total',
    ];

    protected $casts = [
        'qty' => 'integer',
        'harga' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(KasirTransaksi::class, 'transaksi_id');
    }
}