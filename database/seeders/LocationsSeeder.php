<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsSeeder extends Seeder
{
    public function run()
    {
        DB::table('locations')->insert([
            ['name' => 'Oficina Central'],
            ['name' => 'Almacén'],
            ['name' => 'DTI'],
        ]);
    }
}
