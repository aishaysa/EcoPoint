<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'pelanggan_id',
        'jenis_sampah_id',

        'nama_pengirim',
        'no_hp',

        'metode',

        'alamat_jemput',
        'latitude',
        'longitude',

        'titik_kumpul_id',

        'berat',
        'berat_aktual',

        'total_harga',

        'status',
        'tanggal',

        'alamat',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',

        'berat' => 'decimal:2',
        'berat_aktual' => 'decimal:2',

        'total_harga' => 'decimal:2',

        'tanggal' => 'date',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(
            Pelanggan::class,
            'pelanggan_id'
        );
    }

    public function jenisSampah()
    {
        return $this->belongsTo(
            JenisSampah::class,
            'jenis_sampah_id'
        );
    }

    public function jenisSampahs()
    {
        return $this->belongsToMany(
            JenisSampah::class,
            'transaksi_jenis_sampah',
            'transaksi_id',
            'jenis_sampah_id'
        )->withPivot([
            'berat_estimasi',
            'berat_aktual',
        ]);
    }

    public function titikKumpul()
    {
        return $this->belongsTo(
            TitikKumpul::class,
            'titik_kumpul_id'
        );
    }
}