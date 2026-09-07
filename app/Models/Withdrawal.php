<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $table = 'withdrawals';

    protected $fillable = [
        'user_id',
        'package_id',
        'points',
        'amount',
        'payment_method',
        'account_number',
        'account_name',
        'bank_name',
        'status',
        'admin_note',
        'processed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(WithdrawPackage::class);
    }
}