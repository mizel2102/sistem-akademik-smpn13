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
            'latitude' => ['required_unless:status,sick,permission', 'nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['required_unless:status,sick,permission', 'nullable', 'numeric', 'between:-180,180'],
            'distance' => ['required_unless:status,sick,permission', 'nullable', 'integer', 'min:0'],
            'attendance_time' => ['required', 'date'],
            'status' => ['required', Rule::in(['present', 'late', 'sick', 'permission', 'absent'])],
            'selfie' => ['nullable', 'image', 'max:4096'],
            'reason' => ['required_if:status,sick,permission', 'nullable', 'string', 'max:1000'],
            'evidence' => ['required_if:status,sick,permission', 'nullable', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:2048'],
        ];
    }
}
