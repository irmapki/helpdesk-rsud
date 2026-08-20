<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Hardware & Perangkat Medis Terhubung', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SIMRS & Bridging BPJS / Vclaim', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jaringan & Internet RSUD', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Printer & Scanner Resep/Label', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Software & Sistem Operasi', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}