<?php

namespace App\Services;

use App\Models\Saint;

class SaintService
{
    public function getSaintOfTheDay(): Saint
    {
        $today = now();

        $saint = Saint::query()
            ->where('feast_month', $today->month)
            ->where('feast_day', $today->day)
            ->first();

        if ($saint instanceof Saint) {
            return $saint;
        }

        return $this->buildFallbackSaint();
    }

    private function buildFallbackSaint(): Saint
    {
        $saint = new Saint([
            'name' => 'St. Pedro Calungsod',
            'feast_month' => 4,
            'feast_day' => 2,
            'title' => 'Young Filipino Catechist and Martyr',
            'short_story' => 'St. Pedro Calungsod was a young Filipino catechist who helped share the Catholic faith and witnessed to Christ with courage.',
            'full_story' => 'St. Pedro Calungsod was a young Filipino catechist and missionary who gave his life while sharing the Catholic faith. He served with Jesuit missionaries in Guam and helped teach the Gospel with patience and devotion. Even in hardship, he remained faithful, showing courage without bitterness. The Church remembers him as a witness that holiness is possible for the young, the simple, and the willing. His life invites us to stay faithful to Christ, to serve others with generosity, and to trust God in moments that ask for sacrifice. He is a powerful example of courage, fidelity, and missionary love.',
            'virtue' => 'Courage and Faithfulness',
            'life_lesson' => 'Faithfulness means following Christ even when it is difficult.',
            'prayer' => 'St. Pedro Calungsod, pray for us and help us live with courage and faithfulness.',
            'image_path' => 'assets/images/saints/st_pedro_calungsod.png',
            'source_name' => 'Vatican News / Catholic saint calendar reference',
            'source_url' => 'https://www.vaticannews.va/en/saints.html',
        ]);

        $saint->setAttribute('is_fallback', true);

        return $saint;
    }
}