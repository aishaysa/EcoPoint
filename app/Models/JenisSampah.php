<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSampah extends Model
{
    protected $table = 'jenis_sampahs';

    protected $fillable = [
        'nama',
        'poin_per_kg',
        'deskripsi',
    ];
}