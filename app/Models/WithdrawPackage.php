<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawPackage extends Model
{
    use HasFactory;

    protected $table = 'withdraw_packages';

    protected $fillable = [
        'points',
        'amount',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}