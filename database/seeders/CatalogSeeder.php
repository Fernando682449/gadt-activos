<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------
        // STATUSES
        // -------------------------
        $statuses = [
            'Activo',
            'En reparación',
            'Baja',
        ];

        foreach ($statuses as $name) {
            DB::table('statuses')->updateOrInsert(
                ['name' => $name], // condición única
                ['updated_at' => now(), 'created_at' => now()] // valores
            );
        }

        // -------------------------
        // ASSET TYPES
        // -------------------------
        $types = [
            ['name' => 'Computadora', 'description' => 'PC o laptop'],
            ['name' => 'Impresora', 'description' => 'Impresora o multifunción'],
            ['name' => 'Red', 'description' => 'Switch, router, etc.'],
        ];

        foreach ($types as $t) {
            DB::table('asset_types')->updateOrInsert(
                ['name' => $t['name']], // condición única
                [
                    'description' => $t['description'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        // -------------------------
        // LOCATIONS
        // -------------------------
        $locations = [
            ['name' => 'DTI', 'details' => 'Dirección de Tecnologías de la Información'],
            ['name' => 'Contabilidad', 'details' => null],
        ];

        foreach ($locations as $l) {
            DB::table('locations')->updateOrInsert(
                ['name' => $l['name']], // condición única
                [
                    'details' => $l['details'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}