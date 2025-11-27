<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@cpns.go.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'nik' => '1234567890123456',
            'domisili' => 'Jakarta',
            'ttl' => 'Jakarta, 01-01-1990',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Peserta Demo',
            'email' => 'peserta@demo.com',
            'password' => Hash::make('peserta123'),
            'role' => 'peserta',
            'nik' => '9876543210123456',
            'domisili' => 'Bandung',
            'ttl' => 'Bandung, 15-05-1995',
            'email_verified_at' => now(),
        ]);
    }
}
