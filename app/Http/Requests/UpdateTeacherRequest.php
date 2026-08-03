<?php

namespace App\Http\Requests;

use App\Models\Teacher;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('teacher'));
    }

    public function rules(): array
    {
        $teacher = $this->route('teacher');
        $teacherId = $teacher->id;
        $userId = $teacher->user_id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $userId],
            'password' => ['nullable', 'string', 'min:8'],
            'nip' => ['required', 'string', 'max:25', 'unique:teachers,nip,' . $teacherId],
            'subject_name' => ['nullable', 'string', 'max:100'],
            'subject_id' => ['nullable', 'exists:subjects,id'],
            'phone' => ['nullable', 'string', 'max:25'],
            'address' => ['nullable', 'string', 'max:255'],
            'started_at' => ['nullable', 'date'],
        ];
    }
}
