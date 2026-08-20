<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('units')->insert([
            ['name' => 'Rekam Medis', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Farmasi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'IGD', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}