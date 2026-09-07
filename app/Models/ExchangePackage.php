<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangePackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'points',
        'amount',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'package_id');
    }
}