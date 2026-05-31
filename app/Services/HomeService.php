<?php

namespace App\Services;

use App\Models\User;

class HomeService
{
    public function __construct(
        private readonly DashboardService $dashboardService,
        private readonly DailyReflectionService $dailyReflectionService,
        private readonly SaintService $saintService,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function getHomeData(User $user): array
    {
        $dashboardStats = $this->dashboardService->getStats($user);
        $todayProgress = $dashboardStats['today_progress'];
        unset($dashboardStats['today_progress']);

        return [
            'today_progress' => $todayProgress,
            'dashboard_stats' => $dashboardStats,
            'daily_reflection' => $this->dailyReflectionService->getDailyReflectionForToday(),
            'saint_of_the_day' => $this->saintService->getSaintOfTheDay(),
            'mood_recommendations' => $this->getMoodRecommendations(),
        ];
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function getMoodRecommendations(): array
    {
        return [
            ['mood' => 'Anxious', 'bible_reference' => 'John 14:27'],
            ['mood' => 'Grateful', 'bible_reference' => '1 Thessalonians 5:18'],
            ['mood' => 'Tired', 'bible_reference' => 'Matthew 11:28'],
            ['mood' => 'Sad', 'bible_reference' => 'Psalm 34:18'],
            ['mood' => 'Hopeful', 'bible_reference' => 'Jeremiah 29:11'],
            ['mood' => 'Peaceful', 'bible_reference' => 'Philippians 4:7'],
        ];
    }
}