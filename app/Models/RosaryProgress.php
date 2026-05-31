<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RosaryProgress extends Model
{
    protected $table = 'rosary_progress';

    protected $fillable = [
        'user_id',
        'mystery_name',
        'completed_count',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'completed_count' => 'integer',
            'completed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
