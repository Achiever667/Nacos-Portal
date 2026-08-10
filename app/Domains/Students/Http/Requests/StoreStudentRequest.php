<?php

namespace App\Domains\Students\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create students');
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'department' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string', 'max:50'],
            'registration_number' => ['required', 'string', 'max:100', 'unique:students,registration_number'],
            'status' => ['required', 'in:active,inactive,alumni'],
            'date_of_birth' => ['nullable', 'date'],
        ];
    }
}
