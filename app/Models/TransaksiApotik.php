<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiApotik extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_transaksi',
        'apotik_id',
        'pasien_id',
        'user_id',
        'rekam_medis_id',
        'nama_pembeli',
        'tipe_pembeli',
        'subtotal',
        'diskon',
        'pajak',
        'total',
        'bayar',
        'kembalian',
        'metode_pembayaran',
        'status',
        'catatan',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'diskon' => 'decimal:2',
        'pajak' => 'decimal:2',
        'total' => 'decimal:2',
        'bayar' => 'decimal:2',
        'kembalian' => 'decimal:2',
    ];

    public function apotik()
    {
        return $this->belongsTo(Apotik::class);
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class);
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksiApotik::class);
    }

    // Generate nomor transaksi
    public static function generateNoTransaksi()
    {
        $date = now()->format('Ymd');
        $lastTransaction = self::whereDate('created_at', now())->latest()->first();
        
        if ($lastTransaction) {
            $lastNumber = intval(substr($lastTransaction->no_transaksi, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return 'APT-' . $date . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
