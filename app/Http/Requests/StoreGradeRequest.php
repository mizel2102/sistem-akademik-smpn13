<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('teacher');
    }

    public function rules(): array
    {
        return [
            'academic_class_id' => ['required', 'integer', 'exists:academic_classes,id'],
            'student_id' => ['required', 'integer', 'exists:students,id'],
            'assignment' => ['required', 'string', 'max:255'],
            'score' => ['required', 'integer', 'between:0,100'],
            'status' => ['required', 'string', 'max:50'],
        ];
    }
}
