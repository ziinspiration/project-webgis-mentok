<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'id' => 'usr-' . Str::random(32),
            'name' => fake()->name(),
            'nip' => fake()->unique()->numerify('#########'),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_verified' => true,
            'is_allaccess' => false,
            'is_active' => true,
            'token' => Str::random(64),
        ];
    }
}
