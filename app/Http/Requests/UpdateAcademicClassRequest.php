<?php

namespace App\Http\Requests;

use App\Models\AcademicClass;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAcademicClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()?->can('update', $this->route('academic_class')) ?? false;
    }

    public function rules(): array
    {
        $academicClassId = $this->route('academic_class')->id;

        return [
            'name' => ['required', 'string', 'max:255', 'unique:academic_classes,name,' . $academicClassId],
            'teacher_name' => ['nullable', 'string', 'max:255'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'room' => ['nullable', 'string', 'max:50'],
            'schedule' => ['nullable', 'string', 'max:100'],
            'capacity' => ['nullable', 'integer', 'min:1', 'max:999'],
            'status' => ['nullable', 'string', 'in:active,inactive,archived'],
        ];
    }
}
