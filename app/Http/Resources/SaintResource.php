<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaintResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'feast_month' => $this->feast_month,
            'feast_day' => $this->feast_day,
            'title' => $this->title,
            'short_story' => $this->short_story,
            'full_story' => $this->full_story,
            'virtue' => $this->virtue,
            'life_lesson' => $this->life_lesson,
            'prayer' => $this->prayer,
            'image_path' => $this->image_path,
            'source_name' => $this->source_name,
            'source_url' => $this->source_url,
            'is_fallback' => (bool) ($this->is_fallback ?? false),
        ];
    }
}