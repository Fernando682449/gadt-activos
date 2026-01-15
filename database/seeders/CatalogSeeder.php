<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('statuses')->insert([
            ['name' => 'Activo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'En reparación', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Baja', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('asset_types')->insert([
            ['name' => 'Computadora', 'description' => 'PC o laptop', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Impresora', 'description' => 'Impresora o multifunción', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Red', 'description' => 'Switch, router, etc.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('locations')->insert([
            ['name' => 'DTI', 'details' => 'Dirección de Tecnologías de la Información', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Contabilidad', 'details' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
