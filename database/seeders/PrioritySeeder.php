<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('priorities')->insert([
            ['name' => 'High', 'sla_hours' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Medium', 'sla_hours' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Low', 'sla_hours' => 24, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}