<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123'),
                'role' => 'superadmin',
                'is_admin' => 1,
            ]
        );

        // Create Kepala
        User::updateOrCreate(
            ['email' => 'kepala@admin.com'],
            [
                'name' => 'Kepala Dinas',
                'password' => Hash::make('kepala123'),
                'role' => 'kepala',
                'is_admin' => 1,
            ]
        );
    }
}
