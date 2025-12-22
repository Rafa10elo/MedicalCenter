<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id' => ['required','exists:doctors,id'],
            'scheduled_at' => ['required','date','after:now'],
            'notes' => ['nullable','string'],
        ];
    }
}
