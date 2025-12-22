<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class UpdateDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes','string'],
            'email' => ['sometimes','email','unique:doctors,email,' . $this->doctor->id],
            'phone' => ['nullable','string'],
            'bio' => ['nullable','string'],
            'specialty_ids' => ['nullable','array'],
            'specialty_ids.*' => ['exists:specialties,id'],
        ];
    }
}
