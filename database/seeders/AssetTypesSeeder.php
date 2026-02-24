<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetTypesSeeder extends Seeder
{
    public function run()
    {
        DB::table('asset_types')->insert([
            ['name' => 'Laptop'],
            ['name' => 'Monitor'],
            ['name' => 'Impresora'],
        ]);
    }
}

