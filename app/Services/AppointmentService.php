<?php

namespace App\Services;

use App\Enum\AppointmentStatus;
use App\Models\Appointment;
use App\Events\AppointmentBooked;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Exception;

class AppointmentService
{
    public function book(array $data): Appointment
    {
        Gate::authorize('book-appointment');

        return DB::transaction(function () use ($data) {

            $scheduledAt = Carbon::parse($data['scheduled_at']);

            $conflict = Appointment::where('doctor_id', $data['doctor_id'])
                ->where('scheduled_at', $scheduledAt)
                ->exists();

            if ($conflict) {
                throw new Exception('Doctor already has an appointment at this time.');
            }

            $appointment = Appointment::create([
                'doctor_id' => $data['doctor_id'],
                'patient_id' => $data['patient_id'],
                'scheduled_at' => $scheduledAt,
                'status' => AppointmentStatus::Pending->value,
                'notes' => $data['notes'] ?? null,
            ]);

            event(new AppointmentBooked($appointment));

            return $appointment;
        });
    }

    public function doctorAppointments(int $doctorId)
    {
        Gate::authorize('view-appointments');

        return Appointment::where('doctor_id', $doctorId)
            ->orderBy('scheduled_at')
            ->get();
    }

    public function patientAppointments(int $patientId)
    {
        Gate::authorize('view-appointments');

        return Appointment::where('patient_id', $patientId)
            ->orderBy('scheduled_at')
            ->get();
    }
}
