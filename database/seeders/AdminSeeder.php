<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Ilham Ramadhana Hartono',
            'nip' => '223040013',
            'email' => 'ramddbgk@gmail.com',
            'password' => Hash::make('Abzx1234!'),
            'is_verified' => true,
            'is_allaccess' => true,
            'is_active' => true,
            'token' => Str::random(64),
            'email_verified_at' => now(),
        ]);
    }
}
