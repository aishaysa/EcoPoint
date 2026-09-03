<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    protected $table = 'setorans';

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
    return $this->belongsToMany(
        JenisSampah::class,
        'setoran_jenis_sampah',
        'setoran_id',
        'jenis_sampah_id'
    );
}
    public function titikKumpul()
    {
        return $this->belongsTo(TitikKumpul::class);
    }
}