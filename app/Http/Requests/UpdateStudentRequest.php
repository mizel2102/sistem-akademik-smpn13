<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('student'));
    }

    public function rules(): array
    {
        $student = $this->route('student');
        $userId = $student->user_id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $userId],
            'password' => ['nullable', 'string', 'min:8'],
            'student_number' => ['nullable', 'string', 'max:25'],
            'nis' => ['nullable', 'string', 'max:25'],
            'grade_level' => ['nullable', 'string', 'max:10'],
            'academic_class_id' => ['nullable', 'exists:academic_classes,id'],
            'gender' => ['nullable', 'in:male,female,L,P'],
            'birthplace' => ['nullable', 'string', 'max:255'],
            'birthdate' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:255'],
        ];
    }
}
