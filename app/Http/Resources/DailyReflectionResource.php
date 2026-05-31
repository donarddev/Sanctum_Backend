<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyReflectionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reflection_date' => $this->reflection_date,
            'title' => $this->title,
            'bible_reference' => $this->bible_reference,
            'bible_excerpt' => $this->bible_excerpt,
            'reflection' => $this->reflection,
            'action_step' => $this->action_step,
            'prayer' => $this->prayer,
            'source_name' => $this->source_name,
            'source_url' => $this->source_url,
            'is_fallback' => (bool) ($this->is_fallback ?? false),
        ];
    }
}