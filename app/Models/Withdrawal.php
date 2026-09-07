<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'points',
        'amount',
        'payment_method',
        'bank_name',
        'account_number',
        'phone',
        'status',
        'notes',
    ];

    protected $casts = [
        'points' => 'integer',
        'amount' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

public function package()
{
    return $this->belongsTo(ExchangePackage::class, 'package_id');
}
}