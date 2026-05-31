<?php

namespace App\Services;

use App\Models\RosaryProgress;
use App\Models\User;
use Illuminate\Support\Collection;

class RosaryProgressService
{
    private const TOTAL_MYSTERIES = 4;

    /**
     * @return array<string, mixed>
     */
    public function getUserRosaryProgress(User $user): array
    {
        $progress = $user->rosaryProgress()
            ->orderBy('mystery_name')
            ->get()
            ->keyBy('mystery_name');

        $mysteries = collect([
            'Joyful Mysteries',
            'Sorrowful Mysteries',
            'Glorious Mysteries',
            'Luminous Mysteries',
        ])->map(function (string $mysteryName) use ($progress): array {
            $record = $progress->get($mysteryName);

            return [
                'mystery_name' => $mysteryName,
                'completed' => (bool) ($record?->completed_count > 0),
                'completed_count' => (int) ($record?->completed_count ?? 0),
                'completed_at' => $record?->completed_at,
            ];
        })->values();

        $completedMysteriesCount = $mysteries->where('completed', true)->count();

        return [
            'completed_mysteries_count' => $completedMysteriesCount,
            'total_mysteries' => self::TOTAL_MYSTERIES,
            'progress_label' => $completedMysteriesCount.' / '.self::TOTAL_MYSTERIES,
            'mysteries' => $mysteries,
        ];
    }

    public function storeCompletedMystery(User $user, string $mysteryName): RosaryProgress
    {
        $record = RosaryProgress::query()->firstOrNew([
            'user_id' => $user->id,
            'mystery_name' => $mysteryName,
        ]);

        $record->user_id = $user->id;
        $record->mystery_name = $mysteryName;
        $record->completed_count = ((int) $record->completed_count) + 1;
        $record->completed_at = now();
        $record->save();

        return $record;
    }
}