<?php

namespace App\Services;

use App\Models\PeaceSession;
use App\Models\User;

class PeaceSessionService
{
    /**
     * @param  array{session_title: string, duration_seconds: int}  $data
     */
    public function store(User $user, array $data): PeaceSession
    {
        return $user->peaceSessions()->create([
            'session_title' => $data['session_title'],
            'duration_seconds' => $data['duration_seconds'],
            'completed_at' => now(),
        ]);
    }
}
