<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'guard_name' => 'admin'
            ]);
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'doctor'
            ]);
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'patient'
            ]);
        }

        $superAdmin = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'admin'
        ]);

        $doctorRole = Role::firstOrCreate([
            'name' => 'Doctor',
            'guard_name' => 'doctor'
        ]);

        $patientRole = Role::firstOrCreate([
            'name' => 'Patient',
            'guard_name' => 'patient'
        ]);

    $superAdmin->givePermissionTo(Permission::where('guard_name','admin')->get());
      $doctorRole->givePermissionTo(['view-appointments']);
     $patientRole->givePermissionTo(['book-appointment','view-appointments']);
    }
}
