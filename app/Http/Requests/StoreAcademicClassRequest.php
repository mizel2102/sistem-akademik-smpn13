<?php

namespace App\Http\Requests;

use App\Models\AcademicClass;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAcademicClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()?->can('create', AcademicClass::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:academic_classes,name'],
            'teacher_name' => ['nullable', 'string', 'max:255'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'room' => ['nullable', 'string', 'max:50'],
            'schedule' => ['nullable', 'string', 'max:100'],
            'capacity' => ['nullable', 'integer', 'min:1', 'max:999'],
            'status' => ['nullable', 'string', 'in:active,inactive,archived'],
        ];
    }
}
