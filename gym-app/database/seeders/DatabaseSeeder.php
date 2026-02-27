<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gymmanager.local'],
            [
                'name' => 'Admin Gym',
                'role' => User::ROLE_ADMIN,
                'password' => Hash::make('Admin@12345'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'manager@gymmanager.local'],
            [
                'name' => 'Manager Gym',
                'role' => User::ROLE_MANAGER,
                'password' => Hash::make('Manager@12345'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'employee@gymmanager.local'],
            [
                'name' => 'Employé Gym',
                'role' => User::ROLE_EMPLOYEE,
                'password' => Hash::make('Employee@12345'),
            ]
        );
    }
}
