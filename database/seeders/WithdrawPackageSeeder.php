<?php

namespace Database\Seeders;

use App\Models\ExchangePackage;
use Illuminate\Database\Seeder;

class WithdrawPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            ['points' => 100,  'amount' => 10000,  'description' => 'Penarikan Rp 10.000 (100 Poin)'],
            ['points' => 250,  'amount' => 25000,  'description' => 'Penarikan Rp 25.000 (250 Poin)'],
            ['points' => 500,  'amount' => 50000,  'description' => 'Penarikan Rp 50.000 (500 Poin)'],
            ['points' => 1000, 'amount' => 100000, 'description' => 'Penarikan Rp 100.000 (1.000 Poin)'],
        ];

        foreach ($packages as $pkg) {
            ExchangePackage::updateOrCreate(
                ['points' => $pkg['points']],
                [
                    'amount'      => $pkg['amount'],
                    'description' => $pkg['description'],
                    'is_active'   => true,
                ]
            );
        }
    }
}