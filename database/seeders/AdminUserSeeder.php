<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@rsud.test',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin IT',
                'email' => 'admin@rsud.test',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Teknisi',
                'email' => 'teknisi@rsud.test',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Supervisor IT',
                'email' => 'supervisor@rsud.test',
                'password' => Hash::make('password'),
                'role_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}