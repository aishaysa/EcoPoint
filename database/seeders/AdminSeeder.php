<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate([
            'nama_role' => 'admin',
        ]);

        User::updateOrCreate(
            [
                'email' => 'ecopoint@gmail.com',
            ],
            [
                'first_name' => 'EcoPoint',
                'last_name' => 'Admin',
                'name' => 'EcoPoint Admin',
                'password' => Hash::make('Eco1234567890'),
                'role_id' => $adminRole->id,
                'role' => 'admin',
            ]
        );
    }
}