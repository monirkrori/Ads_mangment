<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Enums\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Monir Kafori',
            'email'    => 'monirkfor7@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => Role::ADMIN
        ]);

        User::create([
            'name'     => 'Naruto',
            'email'    => 'naruto@gmail.com',
            'password' => Hash::make('12345678'),
            'role'     => Role::USER
        ]);

        User::create([
            'name'     => 'Lufy',
            'email'    => 'onepicelufy@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => Role::USER
        ]);

        User::create([
            'name'     => 'Gojo',
            'email'    => 'gojosaturo.ramos@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => Role::USER
        ]);
    }
}
