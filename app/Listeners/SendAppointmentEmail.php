<?php

namespace App\Listeners;

use App\Events\AppointmentBooked;
use App\Mail\AppointmentBookedMail;
use Illuminate\Support\Facades\Mail;

class SendAppointmentEmail
{
    public function handle(AppointmentBooked $event): void
    {
        $doctor = $event->appointment->doctor;

        Mail::to($doctor->email)
            ->send(new AppointmentBookedMail($event->appointment));
    }
}
