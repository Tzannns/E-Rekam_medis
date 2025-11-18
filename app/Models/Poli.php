<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;

    protected $table = 'polis';

    protected $fillable = [
        'nama_poli',
        'kode_poli',
        'deskripsi',
        'lokasi',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }

    public function dokter()
    {
        return $this->hasMany(Dokter::class);
    }
}
