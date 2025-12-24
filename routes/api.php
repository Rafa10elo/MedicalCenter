<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\SpecialtyController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthTest;



Route::post('/login', [AuthTest::class, 'login']);

Route::middleware(['auth:sanctum', 'role:Admin'])->group(function() {
    Route::middleware(['sl'])->group(function () {
        Route::get('specialties', [SpecialtyController::class, 'index']);
    });
    Route::post('specialties', [SpecialtyController::class, 'store']);
    Route::put('specialties/{specialty}', [SpecialtyController::class, 'update']);
    Route::delete('specialties/{specialty}', [SpecialtyController::class, 'destroy']);
    Route::get('doctors', [DoctorController::class, 'index']);
    Route::post('doctors', [DoctorController::class, 'store']);
    Route::put('doctors/{doctor}', [DoctorController::class, 'update']);
    Route::delete('doctors/{doctor}', [DoctorController::class, 'destroy']);
});
Route::middleware(['auth:sanctum','role:Patient'])->group(function () {
    Route::post('appointments', [AppointmentController::class, 'book']);
    Route::get('my-appointments', [AppointmentController::class, 'patientAppointments']);
});

Route::middleware(['auth:sanctum','role:Doctor'])->group(function () {
    Route::get('doctor/appointments', [AppointmentController::class, 'doctorAppointments']);
});

