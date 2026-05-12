<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Kepala 1
        User::firstOrCreate(
            ['email' => 'heru@sibaim.com'],
            [
                'name' => 'HERU WEWEG SEMBODO, S.Sos., M.AP',
                'nip' => '197408151993031002',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'role' => 'kepala',
                'email_verified_at' => Carbon::now(),
            ]
        );

        // 2. Akun Kepala 2
        User::firstOrCreate(
            ['email' => 'yugo@sibaim.com'],
            [
                'name' => 'YUGO PRANOTO, S.T, M.T',
                'nip' => '197409102006041006',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'role' => 'kepala',
                'email_verified_at' => Carbon::now(),
            ]
        );

        // 3. Akun Superadmin
        User::firstOrCreate(
            ['email' => 'admin@sibaim.com'],
            [
                'name' => 'RISKI DWI ANANTO',
                'nip' => '198001012005011001',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'role' => 'superadmin',
                'email_verified_at' => Carbon::now(),
            ]
        );
    }
}
