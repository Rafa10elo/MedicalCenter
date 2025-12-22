<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string'],
            'email' => ['required','email','unique:doctors,email'],
            'password' => ['required','min:6'],
            'phone' => ['nullable','string'],
            'bio' => ['nullable','string'],
            'specialty_ids' => ['nullable','array'],
            'specialty_ids.*' => ['exists:specialties,id'],
        ];
    }
}
