<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'apotik_id',
        'supplier_id',
        'kode_obat',
        'nama_obat',
        'kategori',
        'satuan',
        'deskripsi',
        'harga_beli',
        'harga_jual',
        'stok',
        'stok_minimum',
        'tanggal_kadaluarsa',
        'no_batch',
        'status',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'tanggal_kadaluarsa' => 'date',
    ];

    public function apotik()
    {
        return $this->belongsTo(Apotik::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stokObats()
    {
        return $this->hasMany(StokObat::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksiApotik::class);
    }

    // Check if stock is low
    public function isLowStock()
    {
        return $this->stok <= $this->stok_minimum;
    }

    // Check if expired or near expiry
    public function isExpired()
    {
        return $this->tanggal_kadaluarsa && $this->tanggal_kadaluarsa->isPast();
    }

    public function isNearExpiry($days = 30)
    {
        return $this->tanggal_kadaluarsa && 
               $this->tanggal_kadaluarsa->diffInDays(now()) <= $days &&
               !$this->isExpired();
    }
}
