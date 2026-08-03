<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('student');
    }

    public function rules(): array
    {
        return [
            'academic_class_id' => ['required', 'integer', 'exists:academic_classes,id'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'distance' => ['required', 'integer', 'min:0'],
            'attendance_time' => ['required', 'date'],
            'status' => ['required', Rule::in(['present', 'late', 'sick', 'permission', 'absent'])],
            'selfie' => ['nullable', 'image', 'max:4096'],
        ];
    }
}
