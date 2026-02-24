<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetStatusesSeeder extends Seeder
{
    public function run()
    {
        DB::table('asset_statuses')->insert([
            ['name' => 'Activo'],
            ['name' => 'En reparación'],
            ['name' => 'Baja'],
        ]);
    }
}

