<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()?->can('create', Student::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
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
