<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'theme' => ['required', 'in:system,light,dark'],
            'notifications' => ['nullable', 'boolean'],
            'language' => ['required', 'in:id,en'],
        ];
    }
}
