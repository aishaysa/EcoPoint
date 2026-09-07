<?php

namespace Database\Seeders;

use App\Models\WithdrawPackage;
use Illuminate\Database\Seeder;

class WithdrawPackageSeeder extends Seeder
{
    public function run()
    {
        $packages = [
            ['points' => 50, 'amount' => 1000, 'description' => '50 Poin = Rp 1.000'],
            ['points' => 100, 'amount' => 2000, 'description' => '100 Poin = Rp 2.000'],
            ['points' => 250, 'amount' => 5000, 'description' => '250 Poin = Rp 5.000'],
            ['points' => 500, 'amount' => 10000, 'description' => '500 Poin = Rp 10.000'],
            ['points' => 1000, 'amount' => 20000, 'description' => '1000 Poin = Rp 20.000'],
        ];

        foreach ($packages as $pkg) {
            WithdrawPackage::create($pkg);
        }
    }
}