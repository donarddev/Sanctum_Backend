<?php

namespace App\Http\Requests\AskCatechism;

use Illuminate\Foundation\Http\FormRequest;

class AskCatechismRequest extends FormRequest
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
            'question' => ['required', 'string', 'max:1000'],
        ];
    }
}
