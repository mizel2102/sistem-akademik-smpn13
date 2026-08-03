<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCounselingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'student_id' => 'required|exists:students,id',
            'notes' => 'nullable|string|max:5000',
            'follow_up' => 'nullable|string|max:5000',
            'session_at' => 'nullable|date',
            'status' => 'nullable|in:scheduled,completed,cancelled',
            'recommendation' => 'nullable|string|max:5000',
        ];
    }
}
