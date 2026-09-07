<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggans';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'password',
        'no_hp',
        'alamat',
        'poin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function setorans() 
    {
        return $this->hasMany(
            Transaksi::class,
            'pelanggan_id'
        );
    }

    public function transaksis()
    {
        return $this->hasMany(
            Transaksi::class,
            'pelanggan_id'
        );
    }
}