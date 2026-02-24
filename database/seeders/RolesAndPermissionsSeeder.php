<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Limpia cache de permisos (IMPORTANTE)
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Permisos del sistema (incluye categorías y marcas)
        $permissions = [
            // Assets
            'assets.view', 'assets.create', 'assets.edit', 'assets.delete',

            // Custodians
            'custodians.view', 'custodians.create', 'custodians.edit', 'custodians.delete',

            // Assignments
            'assignments.view', 'assignments.create',

            // Maintenances
            'maintenances.view', 'maintenances.create', 'maintenances.close',

            // Audit logs
            'auditlogs.view',

            // Reports
            'reports.view', 'reports.export',

            // NEW: Categories
            'categories.view', 'categories.create', 'categories.edit', 'categories.delete',

            // NEW: Brands
            'brands.view', 'brands.create', 'brands.edit', 'brands.delete',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Roles
        $admin     = Role::firstOrCreate(['name' => 'Administrador']);
        $encargado = Role::firstOrCreate(['name' => 'Encargado Activos']);
        $tecnico   = Role::firstOrCreate(['name' => 'Técnico']);
        $consulta  = Role::firstOrCreate(['name' => 'Consulta']);

        // Admin: TODO
        // (syncPermissions es mejor que givePermissionTo, así siempre queda actualizado)
        $admin->syncPermissions(Permission::all());

        // Encargado de Activos: operativo + catálogos (categories/brands)
        $encargado->syncPermissions([
            'assets.view','assets.create','assets.edit','assets.delete',
            'custodians.view','custodians.create','custodians.edit','custodians.delete',
            'assignments.view','assignments.create',
            'reports.view','reports.export',
            'auditlogs.view',

            // categories/brands
            'categories.view','categories.create','categories.edit','categories.delete',
            'brands.view','brands.create','brands.edit','brands.delete',
        ]);

        // Técnico: mantenimiento y consulta de activos
        $tecnico->syncPermissions([
            'assets.view',
            'maintenances.view','maintenances.create','maintenances.close',
            'auditlogs.view',
        ]);

        // Consulta: solo ver
        $consulta->syncPermissions([
            'assets.view',
            'custodians.view',
            'assignments.view',
            'maintenances.view',
            'reports.view',
            'auditlogs.view',

            'categories.view',
            'brands.view',
        ]);

        // Usuario admin demo (si no existe)
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gadt.local'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin12345*'),
            ]
        );

        if (!$adminUser->hasRole('Administrador')) {
            $adminUser->assignRole('Administrador');
        }
    }
}