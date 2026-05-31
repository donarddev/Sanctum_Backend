<?php

namespace App\Http\Requests\PeaceSession;

use Illuminate\Foundation\Http\FormRequest;

class StorePeaceSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'session_title' => ['required', 'string', 'max:255'],
            'duration_seconds' => ['required', 'integer', 'min:1'],
        ];
    }
}
