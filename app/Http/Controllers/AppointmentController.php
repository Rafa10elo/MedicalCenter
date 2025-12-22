<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Services\AppointmentService;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{

    public function __construct(private AppointmentService $service) {}

    public function book(BookAppointmentRequest $request)
    {
        $appointment = $this->service->book(
            array_merge(
                $request->validated(),
                ['patient_id' => $request->user()->id]
            )
        );

        return response()->json($appointment, 201);
    }
    public function doctorAppointments()
    {
        return AppointmentResource::collection(
            $this->service->doctorAppointments(auth('sanctum')->id())
        );
    }

    public function patientAppointments()
    {
        return AppointmentResource::collection(

            $this->service->patientAppointments(auth('sanctum')->id())
        );
    }
}
