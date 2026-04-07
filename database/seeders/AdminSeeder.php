<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
        ]);
    }
}