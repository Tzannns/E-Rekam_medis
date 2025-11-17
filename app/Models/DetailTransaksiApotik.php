<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiApotik extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_apotik_id',
        'obat_id',
        'jumlah',
        'harga_satuan',
        'diskon',
        'subtotal',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'diskon' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function transaksi()
    {
        return $this->belongsTo(TransaksiApotik::class, 'transaksi_apotik_id');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
