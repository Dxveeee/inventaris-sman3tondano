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
            'email'    => 'admin@sman3tondano.sch.id',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Kepala Sekolah',
            'email'    => 'kepsek@sman3tondano.sch.id',
            'password' => Hash::make('password123'),
            'role'     => 'kepala_sekolah',
        ]);
    }
}
