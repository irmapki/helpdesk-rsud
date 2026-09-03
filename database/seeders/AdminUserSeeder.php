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
                'email' => 'ayu@rsud.test',
                'name' => 'Ayu (Teknisi SIMRS)',
                'phone' => '081234567895',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'unit_id' => null,
                'specialization' => 'SIMRS, Database & Bridging BPJS',
                'is_active' => true,
            ],
            [
                'email' => 'yuda@rsud.test',
                'name' => 'Yuda (Teknisi Jaringan)',
                'phone' => '081234567892',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'unit_id' => null,
                'specialization' => 'Jaringan LAN, WiFi & Mikrotik Server',
                'is_active' => true,
            ],
            [
                'email' => 'fahmi@rsud.test',
                'name' => 'Fahmi (Teknisi Hardware)',
                'phone' => '081234567893',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'unit_id' => null,
                'specialization' => 'Hardware Komputer, Printer & Kelistrikan IT',
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