<?php

namespace App\Domains\Students\Http\Requests;

use App\Domains\Students\Models\Student;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $student = $this->route('student');

        return $student instanceof Student && $this->user()->can('edit students');
    }

    public function rules(): array
    {
        $student = $this->route('student');

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email,' . $student->id],
            'phone' => ['nullable', 'string', 'max:50'],
            'department' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string', 'max:50'],
            'registration_number' => ['required', 'string', 'max:100', 'unique:students,registration_number,' . $student->id],
            'status' => ['required', 'in:active,inactive,alumni'],
            'date_of_birth' => ['nullable', 'date'],
        ];
    }
}
