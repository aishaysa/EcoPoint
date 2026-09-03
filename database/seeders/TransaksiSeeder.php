<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use App\Models\JenisSampah;
use App\Models\Transaksi;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil pelanggan dan jenis sampah yang sudah ada
        $pelanggan = Pelanggan::first();
        $sampah = JenisSampah::first();

        if ($pelanggan && $sampah) {
            // Buat 3 transaksi dengan data lengkap
            $transaksis = [
                [
                    'pelanggan_id' => $pelanggan->id,
                    'jenis_sampah_id' => $sampah->id,
                    'berat' => 5.5,
                    'total_harga' => 55000,
                    'status' => 'completed',
                    'rating' => 5,
                    'keterangan' => 'Setoran pertama',
                    'created_at' => now()->subDays(2),
                ],
                [
                    'pelanggan_id' => $pelanggan->id,
                    'jenis_sampah_id' => $sampah->id,
                    'berat' => 3.2,
                    'total_harga' => 32000,
                    'status' => 'completed',
                    'rating' => 4,
                    'keterangan' => 'Setoran kedua',
                    'created_at' => now()->subDays(1),
                ],
                [
                    'pelanggan_id' => $pelanggan->id,
                    'jenis_sampah_id' => $sampah->id,
                    'berat' => 2.0,
                    'total_harga' => 20000,
                    'status' => 'pending',
                    'rating' => null,
                    'keterangan' => 'Setoran ketiga (pending)',
                    'created_at' => now(),
                ],
            ];

            foreach ($transaksis as $data) {
                Transaksi::create($data);
            }
        }
    }
}
