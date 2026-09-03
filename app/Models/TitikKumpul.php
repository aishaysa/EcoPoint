<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TitikKumpul extends Model
{
    protected $table = 'titik_kumpul';

    protected $fillable = [
        'nama',
        'alamat',
        'latitude',
        'longitude',
        'kontak',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function transaksis()
    {
        return $this->hasMany(
            Transaksi::class,
            'titik_kumpul_id'
        );
    }
}