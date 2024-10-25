<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Annual Transfer'],
            ['name' => 'Disciplinary'],
            ['name' => 'Divisional Transfer'],
            ['name' => 'Grade Promotion'],
            ['name' => 'New Recruitment'],
            ['name' => 'On request'],
            ['name' => 'Promotion'],
            ['name' => 'Service Requirement'],
            ['name' => 'Temporary'],
        ];

        DB::table('hrm_mst_promo_type')->insert($types);
    }
}
