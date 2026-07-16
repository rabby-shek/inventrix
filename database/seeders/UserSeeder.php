<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create  new users
        User::create([
            'name' => 'admin',
            'email' => 'admin.inventrix@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'manager',
            'email' => 'manager.inventrix@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'manager',
        ]);

        User::create([
            'name' => 'staff',
            'email' => 'staff.inventrix@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'viewer',
            'email' => 'viewer.inventrix@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'viewer',
        ]);
    }
}
