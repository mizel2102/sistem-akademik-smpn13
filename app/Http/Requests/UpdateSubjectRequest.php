<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:191',
            'code' => 'nullable|string|max:50',
            'teacher_id' => 'nullable|exists:teachers,id',
        ];
    }
}
