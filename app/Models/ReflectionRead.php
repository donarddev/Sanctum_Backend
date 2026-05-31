<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReflectionRead extends Model
{
    protected $fillable = [
        'user_id',
        'daily_reflection_id',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dailyReflection(): BelongsTo
    {
        return $this->belongsTo(DailyReflection::class);
    }
}