<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage-specialties',
            'manage-doctors',
            'view-appointments',
            'book-appointment',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'sanctum',
            ]);
        }

        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'sanctum',
        ]);

        $doctorRole = Role::firstOrCreate([
            'name' => 'Doctor',
            'guard_name' => 'sanctum',
        ]);

        $patientRole = Role::firstOrCreate([
            'name' => 'Patient',
            'guard_name' => 'sanctum',
        ]);

        $adminRole->syncPermissions([
            'manage-specialties',
            'manage-doctors',
            'view-appointments',
        ]);

        $doctorRole->syncPermissions([
            'view-appointments',
        ]);

        $patientRole->syncPermissions([
            'book-appointment',
            'view-appointments',
        ]);
    }
}
