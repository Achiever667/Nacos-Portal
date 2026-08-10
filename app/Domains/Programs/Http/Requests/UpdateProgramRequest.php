<?php

namespace App\Domains\Programs\Http\Requests;

use App\Domains\Programs\Models\Program;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        $program = $this->route('program');

        return $program instanceof Program && $this->user()->can('edit programs');
    }

    public function rules(): array
    {
        $program = $this->route('program');

        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:programs,code,' . $program->id],
            'department' => ['required', 'string', 'max:255'],
            'overview' => ['required', 'string', 'min:20'],
            'career_opportunities' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
