<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TitikKumpul;

class TitikKumpulSeeder extends Seeder
{
    public function run()
    {
        TitikKumpul::create([
            'nama' => 'EcoPoint Pusat',
            'alamat' => 'Jl. Lingkungan Hijau No. 10, Jakarta',
            'latitude' => -6.2088,
            'longitude' => 106.8456,
            'kontak' => '021-1234567',
            'is_active' => true,
        ]);

        TitikKumpul::create([
            'nama' => 'Drop Point Kebon Jeruk',
            'alamat' => 'Jl. Jeruk Manis No. 5, Jakarta Barat',
            'latitude' => -6.1754,
            'longitude' => 106.7892,
            'kontak' => '08123456789',
            'is_active' => true,
        ]);

        TitikKumpul::create([
            'nama' => 'Titik Kumpul Sudirman',
            'alamat' => 'Jl. Sudirman No. 12, Jakarta Pusat',
            'latitude' => -6.2146,
            'longitude' => 106.8451,
            'kontak' => '08134567890',
            'is_active' => true,
        ]);
    }
}