<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $userRole = Role::where('slug', 'user')->first();

        User::updateOrCreate(
            ['email' => 'alhudaadmin@gmail.com'],
            [
                'name' => 'Admin',
                'role_id' => $adminRole->id,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'alhudacustomer@gmail.com'],
            [
                'name' => 'Demo Customer',
                'role_id' => $userRole->id,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}