<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    use HasFactory;

    protected $table = 'setoran';

    protected $fillable = [
        'user_id',
        'pelanggan_id',
        'tanggal',
        'metode',
        'berat_aktual',
        'status',
        'alamat_jemput',
        'latitude',
        'longitude',
        'titik_kumpul_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function jenisSampahs()
    {
        return $this->belongsToMany(JenisSampah::class, 'setoran_jenis_sampah')
            ->withPivot('berat_estimasi', 'berat_aktual');
    }

    public function titikKumpul()
    {
        return $this->belongsTo(TitikKumpul::class);
    }
}