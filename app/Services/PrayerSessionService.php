<?php

namespace App\Services;

use App\Models\PrayerSession;
use App\Models\User;

class PrayerSessionService
{
    /**
     * @param  array{prayer_title: string, prayer_category?: string|null, mood?: string|null}  $data
     */
    public function store(User $user, array $data): PrayerSession
    {
        return $user->prayerSessions()->create([
            'prayer_title' => $data['prayer_title'],
            'prayer_category' => $data['prayer_category'] ?? null,
            'mood' => $data['mood'] ?? null,
            'completed_at' => now(),
        ]);
    }
}
