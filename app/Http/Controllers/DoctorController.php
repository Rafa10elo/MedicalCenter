<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Services\DoctorService;

class DoctorController extends Controller
{
    public function __construct(private DoctorService $service) {}

    public function index()
    {
        return DoctorResource::collection(
            $this->service->list()
        );
    }

    public function store(StoreDoctorRequest $request)
    {
        $doctor = $this->service->create($request->validated());
        return new DoctorResource($doctor);
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $doctor = $this->service->update($doctor, $request->validated());
        return new DoctorResource($doctor);
    }

    public function destroy(Doctor $doctor)
    {
        $this->service->delete($doctor);

        return response()->noContent();
    }
}
