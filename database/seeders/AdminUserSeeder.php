<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'mychelmunthe28@gmail.com';
        $password = '12345678';

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'nama' => 'Administrator',
                'password' => Hash::make($password),
                'role' => 'admin',
                'status' => 'aktif',
                'email_verified_at' => now(),
            ]
        );

        Admin::updateOrCreate(
            ['user_id' => $user->id],
            [
                'email' => $email,
                'password' => Hash::make($password),
            ]
        );
    }
}
