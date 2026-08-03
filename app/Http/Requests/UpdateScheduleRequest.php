<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'academic_class_id' => 'sometimes|required|exists:academic_classes,id',
            'academic_year_id' => 'sometimes|required|exists:academic_years,id',
            'semester_id' => 'sometimes|required|exists:semesters,id',
            'subject_id' => 'sometimes|required|exists:subjects,id',
            'teacher_id' => 'sometimes|required|exists:teachers,id',
            'day' => 'sometimes|required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'sometimes|required_with:end_time|date_format:H:i',
            'end_time' => 'sometimes|required_with:start_time|date_format:H:i|after:start_time',
        ];
    }
}

