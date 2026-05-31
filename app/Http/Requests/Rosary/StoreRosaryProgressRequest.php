<?php

namespace App\Http\Requests\Rosary;

use Illuminate\Foundation\Http\FormRequest;

class StoreRosaryProgressRequest extends FormRequest
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
            'mystery_name' => ['required', 'string', 'in:Joyful Mysteries,Sorrowful Mysteries,Glorious Mysteries,Luminous Mysteries'],
        ];
    }
}