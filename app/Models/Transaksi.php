<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'setoran'; // ← nama tabel yang benar

    protected $fillable = [
        'user_id',
        'pelanggan_id',
        'nama_pengirim',
        'no_hp',
        'metode',
        'alamat_jemput',
        'latitude',
        'longitude',
        'titik_kumpul_id',
        'status',
        'berat_aktual',
        'jenis_sampah_id',
        'berat',
        'total_harga',
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
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class, 'jenis_sampah_id');
    }

    // ⚠️ Relasi many-to-many dengan pivot yang BENAR
    public function jenisSampahs()
    {
        return $this->belongsToMany(
            JenisSampah::class,
            'setoran_jenis_sampah',
            'setoran_id',        // ← foreign key dari tabel setoran (bukan transaksi_id)
            'jenis_sampah_id'
        )->withPivot('berat_estimasi', 'berat_aktual');
    }

    public function titikKumpul()
    {
        return $this->belongsTo(TitikKumpul::class, 'titik_kumpul_id');
    }
}