<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('teacher');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'room' => ['required', 'string', 'max:50'],
            'schedule' => ['required', 'string', 'max:255'],
        ];
    }
}
