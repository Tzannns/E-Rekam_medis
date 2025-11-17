<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'deskripsi',
        'stok_awal',
        'stok_saat_ini',
        'stok_minimal',
        'satuan',
        'harga_satuan',
        'total_nilai',
        'lokasi',
        'tanggal_masuk',
        'tanggal_kadaluarsa',
        'status',
        'supplier',
        'nomor_batch',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_masuk' => 'date',
            'tanggal_kadaluarsa' => 'date',
            'harga_satuan' => 'decimal:2',
            'total_nilai' => 'decimal:2',
        ];
    }

    public function getStokStatusAttribute(): string
    {
        if ($this->stok_saat_ini <= 0) {
            return 'Habis';
        }
        if ($this->stok_saat_ini <= $this->stok_minimal) {
            return 'Rendah';
        }

        return 'Normal';
    }

    public function getIsKadaluarsaAttribute(): bool
    {
        if (! $this->tanggal_kadaluarsa) {
            return false;
        }

        return now()->isAfter($this->tanggal_kadaluarsa);
    }
}
