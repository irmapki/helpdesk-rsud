<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'email' => 'superadmin@rsud.test',
                'name' => 'Super Admin',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'unit_id' => null,
                'specialization' => 'System Administrator',
                'is_active' => true,
            ],
            [
                'email' => 'admin@rsud.test',
                'name' => 'Admin IT (Helpdesk)',
                'phone' => '081234567891',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'unit_id' => null,
                'specialization' => 'Helpdesk & Triage Coordinator',
                'is_active' => true,
            ],
            [
                'email' => 'teknisi@rsud.test',
                'name' => 'Rian (Teknisi Jaringan & Hardware)',
                'phone' => '081234567892',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'unit_id' => null,
                'specialization' => 'Hardware, Printer & Jaringan LAN',
                'is_active' => true,
            ],
            [
                'email' => 'teknisi2@rsud.test',
                'name' => 'Bayu (Teknisi SIMRS)',
                'phone' => '081234567893',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'unit_id' => null,
                'specialization' => 'SIMRS, Bridging BPJS & Database',
                'is_active' => true,
            ],
            [
                'email' => 'supervisor@rsud.test',
                'name' => 'Supervisor IT',
                'phone' => '081234567894',
                'password' => Hash::make('password'),
                'role_id' => 4,
                'unit_id' => null,
                'specialization' => 'Kepala Instalasi TIK RSUD',
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}