<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole   = Role::where('name', 'Admin')->first();
        $doctorRole  = Role::where('name', 'Doctor')->first();
        $patientRole = Role::where('name', 'Patient')->first();

        $admin = Admin::firstOrCreate(
            ['email' => 'admin@test.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password')]
        );
        $admin->assignRole($adminRole);

        $doctor = Doctor::firstOrCreate(
            ['email' => 'doctor@test.com'],
            [
                'name' => 'Dr John',
                'phone' => '123456',
                'bio' => 'Specialist',
                'password' => Hash::make('password')
            ]
        );
        $doctor->assignRole($doctorRole);

        $patient = Patient::firstOrCreate(
            ['email' => 'patient@test.com'],
            [
                'name' => 'Patient One',
                'phone' => '999999',
                'dob' => '1990-01-01',
                'password' => Hash::make('password')
            ]
        );
        $patient->assignRole($patientRole);
    }
}
