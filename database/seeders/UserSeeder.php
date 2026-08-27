<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('12341234'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Kepala Sekolah',
            'email'    => 'kepsek@gmail.com',
            'password' => Hash::make('12341234'),
            'role'     => 'kepala_sekolah',
        ]);
    }
}
