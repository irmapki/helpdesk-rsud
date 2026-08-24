<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('units')->insert([
            ['name' => 'Instalasi Gawat Darurat (IGD)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Instalasi Farmasi & Depo Obat', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rekam Medis & Admisi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Poli Rawat Jalan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Laboratorium & Bank Darah', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Instalasi Radiologi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang Rawat Inap', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kamar Operasi (OK) & ICU', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kasir & Keuangan', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}