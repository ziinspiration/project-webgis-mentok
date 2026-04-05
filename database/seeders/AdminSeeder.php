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
            'name' => 'Administrator Mentok',
            'nip' => '223040013',
            'email' => 'admin@mentok.go.id',
            'password' => Hash::make('Abzx1234!'),
        ]);
    }
}