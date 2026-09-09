<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPoin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jumlah',
        'jenis',
        'deskripsi',
        'saldo_sebelumnya',
        'saldo_setelah',
        'referensi_id',
        'referensi_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getJenisLabelAttribute()
    {
        $labels = [
            'setoran'   => 'Setoran Sampah',
            'penarikan' => 'Penarikan Poin',
            'refund'    => 'Refund Penarikan',
        ];
        return $labels[$this->jenis] ?? ucfirst($this->jenis);
    }

    public function getStatusClassAttribute()
    {
        $map = [
            'setoran'   => 'status-success',
            'penarikan' => 'status-failed',
            'refund'    => 'status-pending',
        ];
        return $map[$this->jenis] ?? 'status-pending';
    }
}