<?php

namespace App\Services;

use App\Models\DailyReflection;
use App\Models\ReflectionRead;
use App\Models\User;

class DailyReflectionService
{
    public function getDailyReflectionForToday(): DailyReflection
    {
        $today = now()->toDateString();

        $reflection = DailyReflection::query()
            ->whereDate('reflection_date', $today)
            ->first();

        if ($reflection instanceof DailyReflection) {
            return $reflection;
        }

        $availableCount = DailyReflection::query()->count();

        if ($availableCount > 0) {
            $offset = now()->dayOfYear % $availableCount;

            $rotated = DailyReflection::query()
                ->orderBy('reflection_date')
                ->offset($offset)
                ->first();

            if ($rotated instanceof DailyReflection) {
                return $rotated;
            }
        }

        return $this->buildFallbackReflection();
    }

    public function markTodayAsRead(User $user): ?ReflectionRead
    {
        $reflection = $this->getDailyReflectionForToday();

        if (! $reflection->exists) {
            return null;
        }

        return ReflectionRead::query()->updateOrCreate(
            [
                'user_id' => $user->id,
                'daily_reflection_id' => $reflection->id,
            ],
            [
                'read_at' => now(),
            ]
        );
    }

    private function buildFallbackReflection(): DailyReflection
    {
        $reflection = new DailyReflection([
            'reflection_date' => now()->toDateString(),
            'title' => 'Peace in Christ',
            'bible_reference' => 'John 14:27',
            'bible_excerpt' => 'Peace I leave with you; my peace I give to you.',
            'reflection' => 'Jesus offers a peace that remains even when life feels uncertain.',
            'action_step' => 'Offer one worry to God today and choose one act of kindness.',
            'prayer' => 'Lord Jesus, fill my heart with Your peace and help me trust You today. Amen.',
            'source_name' => 'USCCB Daily Bible Readings / Catholic Bible reference',
            'source_url' => 'https://bible.usccb.org/daily-bible-reading',
        ]);

        $reflection->setAttribute('is_fallback', true);

        return $reflection;
    }
}