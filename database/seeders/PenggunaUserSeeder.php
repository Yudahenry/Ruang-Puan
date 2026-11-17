<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PenggunaUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'mychelmunthe@gmail.com';
        $password = 'm12345678';

        User::updateOrCreate(
            ['email' => $email],
            [
                'nama' => 'Mychel Munthe',
                'alias' => 'Mychel',
                'password' => Hash::make($password),
                'role' => 'pengguna',
                'status' => 'aktif',
                'email_verified_at' => now(),
            ]
        );
    }
}
