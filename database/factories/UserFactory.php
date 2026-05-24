<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => UserRole::Customer,
            'status' => UserStatus::Active,
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'city' => fake()->randomElement(['Lagos', 'Lekki', 'Ikeja', 'Victoria Island', 'Abuja', 'Port Harcourt']),
            'state' => fake()->randomElement(['Lagos', 'FCT', 'Rivers', 'Ogun', 'Oyo']),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function merchant(): static
    {
        return $this->state(fn() => ['role' => UserRole::Merchant]);
    }

    public function admin(): static
    {
        return $this->state(fn() => ['role' => UserRole::Admin]);
    }
}
