<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DailyReflection extends Model
{
    protected $fillable = [
        'reflection_date',
        'title',
        'bible_reference',
        'bible_excerpt',
        'reflection',
        'action_step',
        'prayer',
        'source_name',
        'source_url',
    ];

    protected function casts(): array
    {
        return [
            'reflection_date' => 'date',
        ];
    }

    public function reflectionReads(): HasMany
    {
        return $this->hasMany(ReflectionRead::class);
    }
}