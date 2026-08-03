<?php

namespace App\Http\Requests;

use App\Models\Teacher;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()?->can('create', Teacher::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:8'],
            'nip' => ['required', 'string', 'max:25', 'unique:teachers,nip'],
            'subject_name' => ['nullable', 'string', 'max:100'],
            'subject_id' => ['nullable', 'exists:subjects,id'],
            'phone' => ['nullable', 'string', 'max:25'],
            'address' => ['nullable', 'string', 'max:255'],
            'started_at' => ['nullable', 'date'],
        ];
    }
}
