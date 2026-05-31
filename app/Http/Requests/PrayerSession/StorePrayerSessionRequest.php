<?php

namespace App\Http\Requests\PrayerSession;

use Illuminate\Foundation\Http\FormRequest;

class StorePrayerSessionRequest extends FormRequest
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
            'prayer_title' => ['required', 'string', 'max:255'],
            'prayer_category' => ['nullable', 'string', 'max:255'],
            'mood' => ['nullable', 'string', 'max:255'],
        ];
    }
}
