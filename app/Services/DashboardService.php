<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * @return array<string, mixed>
     */
    public function getStats(User $user): array
    {
        $today = now()->startOfDay();

        $prayedToday = $user->prayerSessions()
            ->whereNotNull('completed_at')
            ->whereDate('completed_at', $today)
            ->exists();

        $completedPeaceToday = $user->peaceSessions()
            ->whereNotNull('completed_at')
            ->whereDate('completed_at', $today)
            ->exists();

        $readReflectionToday = $user->reflectionReads()
            ->whereDate('read_at', $today)
            ->exists();

        $rosaryCompleted = $user->rosaryProgress()
            ->where('completed_count', '>', 0)
            ->pluck('mystery_name')
            ->unique()
            ->count();

        $rosaryCompleted = min($rosaryCompleted, 4);

        return [
            'prayer_streak' => $this->calculatePrayerStreak($user),
            'completed_prayers_count' => $user->prayerSessions()->count(),
            'peace_sessions_count' => $user->peaceSessions()->count(),
            'rosary_progress' => $rosaryCompleted.' / 4',
            'favorite_prayer' => $this->getFavoritePrayer($user),
            'today_progress' => [
                'prayed_today' => $prayedToday,
                'completed_peace_today' => $completedPeaceToday,
                'read_reflection_today' => $readReflectionToday,
            ],
        ];
    }

    private function calculatePrayerStreak(User $user): int
    {
        $dates = $user->prayerSessions()
            ->whereNotNull('completed_at')
            ->select(DB::raw('DATE(completed_at) as prayer_date'))
            ->distinct()
            ->pluck('prayer_date')
            ->map(fn ($date) => Carbon::parse($date)->toDateString())
            ->unique()
            ->values();

        if ($dates->isEmpty()) {
            return 0;
        }

        $current = now()->startOfDay();

        if (! $dates->contains($current->toDateString())) {
            $current = $current->copy()->subDay();
        }

        $streak = 0;

        while ($dates->contains($current->toDateString())) {
            $streak++;
            $current = $current->copy()->subDay();
        }

        return $streak;
    }

    private function getFavoritePrayer(User $user): string
    {
        $favorite = $user->prayerSessions()
            ->whereNotNull('prayer_title')
            ->select('prayer_title', DB::raw('COUNT(*) as total'))
            ->groupBy('prayer_title')
            ->orderByDesc('total')
            ->first();

        return $favorite?->prayer_title ?? 'None';
    }
}
