<?php

namespace App\Services;

use App\Models\Doctor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class DoctorService
{
    public function list()
    {
        Gate::authorize('manage-doctors');

        return Doctor::with('specialties')->latest()->get();
    }

    public function create(array $data): Doctor
    {
        Gate::authorize('manage-doctors');

        return DB::transaction(function () use ($data) {
            $doctor = Doctor::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'] ?? null,
                'bio' => $data['bio'] ?? null,
            ]);

            if (!empty($data['specialty_ids'])) {
                $doctor->specialties()->sync($data['specialty_ids']);
            }

            return $doctor;
        });
    }

    public function update(Doctor $doctor, array $data): Doctor
    {
        Gate::authorize('manage-doctors');

        return DB::transaction(function () use ($doctor, $data) {
            $doctor->update([
                'name' => $data['name'] ?? $doctor->name,
                'email' => $data['email'] ?? $doctor->email,
                'phone' => $data['phone'] ?? $doctor->phone,
                'bio' => $data['bio'] ?? $doctor->bio,
            ]);

            if (isset($data['specialty_ids'])) {
                $doctor->specialties()->sync($data['specialty_ids']);
            }

            return $doctor;
        });
    }

    public function delete(Doctor $doctor): void
    {
        Gate::authorize('manage-doctors');

        if ($doctor->appointments()->exists()) {
            abort(403, 'Doctor with appointments cannot be deleted.');
        }

        $doctor->delete();
    }
}
