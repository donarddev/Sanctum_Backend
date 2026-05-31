<?php

namespace Database\Seeders;

use App\Models\DailyReflection;
use Illuminate\Database\Seeder;

class DailyReflectionSeeder extends Seeder
{
    public function run(): void
    {
        $today = now()->startOfDay();

        $reflections = [
            [
                'title' => 'Peace for a Restless Heart',
                'bible_reference' => 'John 14:27',
                'bible_excerpt' => 'Peace I leave with you; my peace I give to you.',
                'reflection' => 'Jesus offers a peace that remains even when life feels uncertain.',
                'action_step' => 'Offer one worry to God today and choose one act of kindness.',
                'prayer' => 'Lord Jesus, fill my heart with Your peace and help me trust You today. Amen.',
                'source_name' => 'USCCB Daily Bible Readings / Catholic Bible reference',
                'source_url' => 'https://bible.usccb.org/daily-bible-reading',
            ],
            [
                'title' => 'Rest for the Weary',
                'bible_reference' => 'Matthew 11:28',
                'bible_excerpt' => 'Come to me, all you who labor and are burdened.',
                'reflection' => 'Christ welcomes tired hearts and gives rest that renews the soul.',
                'action_step' => 'Take a short pause and pray before returning to your tasks.',
                'prayer' => 'Jesus, give me rest and renewed strength today. Amen.',
                'source_name' => 'USCCB Daily Bible Readings / Catholic Bible reference',
                'source_url' => 'https://bible.usccb.org/daily-bible-reading',
            ],
            [
                'title' => 'Near to the Brokenhearted',
                'bible_reference' => 'Psalm 34:18',
                'bible_excerpt' => 'The Lord is close to the brokenhearted.',
                'reflection' => 'God does not distance himself from sorrow. He comes close to heal and strengthen.',
                'action_step' => 'Speak one honest prayer about what hurts today.',
                'prayer' => 'Lord, stay close to me and lift my heart with hope. Amen.',
                'source_name' => 'USCCB Daily Bible Readings / Catholic Bible reference',
                'source_url' => 'https://bible.usccb.org/daily-bible-reading',
            ],
            [
                'title' => 'The Peace of God',
                'bible_reference' => 'Philippians 4:7',
                'bible_excerpt' => 'The peace of God that surpasses all understanding.',
                'reflection' => 'God’s peace can guard the mind and heart even when circumstances are unsettled.',
                'action_step' => 'Pray this verse before a stressful conversation.',
                'prayer' => 'Holy Spirit, guard my heart with Your peace. Amen.',
                'source_name' => 'USCCB Daily Bible Readings / Catholic Bible reference',
                'source_url' => 'https://bible.usccb.org/daily-bible-reading',
            ],
            [
                'title' => 'Give Thanks Always',
                'bible_reference' => '1 Thessalonians 5:18',
                'bible_excerpt' => 'In all circumstances give thanks.',
                'reflection' => 'Gratitude opens our eyes to God’s care in the middle of ordinary life.',
                'action_step' => 'Name three blessings from today and thank God for them.',
                'prayer' => 'Father, teach me to live with gratitude. Amen.',
                'source_name' => 'USCCB Daily Bible Readings / Catholic Bible reference',
                'source_url' => 'https://bible.usccb.org/daily-bible-reading',
            ],
            [
                'title' => 'Hope for the Future',
                'bible_reference' => 'Jeremiah 29:11',
                'bible_excerpt' => 'Plans for your welfare and not for woe.',
                'reflection' => 'God’s plans are not empty words. He is already at work guiding us toward hope.',
                'action_step' => 'Entrust one future worry to the Lord in prayer.',
                'prayer' => 'Father, anchor my heart in the hope You promise. Amen.',
                'source_name' => 'USCCB Daily Bible Readings / Catholic Bible reference',
                'source_url' => 'https://bible.usccb.org/daily-bible-reading',
            ],
            [
                'title' => 'Blessed Are the Peacemakers',
                'bible_reference' => 'Matthew 5:9',
                'bible_excerpt' => 'Blessed are the peacemakers.',
                'reflection' => 'Peace begins with the choices we make in speech, patience, and mercy.',
                'action_step' => 'Choose one peaceful response in a difficult moment today.',
                'prayer' => 'Lord, make me an instrument of Your peace. Amen.',
                'source_name' => 'USCCB Daily Bible Readings / Catholic Bible reference',
                'source_url' => 'https://bible.usccb.org/daily-bible-reading',
            ],
            [
                'title' => 'Let It Be Done',
                'bible_reference' => 'Luke 1:38',
                'bible_excerpt' => 'Let it be done to me according to your word.',
                'reflection' => 'Mary’s trust shows us how to welcome God’s will with courage and humility.',
                'action_step' => 'Say yes to one good thing that God is placing before you today.',
                'prayer' => 'Lord, give me Mary’s trust and readiness. Amen.',
                'source_name' => 'USCCB Daily Bible Readings / Catholic Bible reference',
                'source_url' => 'https://bible.usccb.org/daily-bible-reading',
            ],
            [
                'title' => 'The Lord Is My Shepherd',
                'bible_reference' => 'Psalm 23:1',
                'bible_excerpt' => 'The Lord is my shepherd; there is nothing I lack.',
                'reflection' => 'God shepherds us with care and provides what is truly needed for each day.',
                'action_step' => 'Notice one way God has provided for you recently.',
                'prayer' => 'Lord, guide me and provide what I need. Amen.',
                'source_name' => 'USCCB Daily Bible Readings / Catholic Bible reference',
                'source_url' => 'https://bible.usccb.org/daily-bible-reading',
            ],
            [
                'title' => 'For Those Who Love God',
                'bible_reference' => 'Romans 8:28',
                'bible_excerpt' => 'All things work for good for those who love God.',
                'reflection' => 'Even hidden struggles can be used by God for good beyond what we can see now.',
                'action_step' => 'Entrust one difficult situation to God today.',
                'prayer' => 'Lord, help me trust Your providence in every circumstance. Amen.',
                'source_name' => 'USCCB Daily Bible Readings / Catholic Bible reference',
                'source_url' => 'https://bible.usccb.org/daily-bible-reading',
            ],
            [
                'title' => 'Trust in the Lord',
                'bible_reference' => 'Proverbs 3:5',
                'bible_excerpt' => 'Trust in the Lord with all your heart.',
                'reflection' => 'Trust deepens when we stop trying to control everything and let God lead us.',
                'action_step' => 'Pray for guidance before making your next decision.',
                'prayer' => 'Lord, teach me to trust You with my whole heart. Amen.',
                'source_name' => 'USCCB Daily Bible Readings / Catholic Bible reference',
                'source_url' => 'https://bible.usccb.org/daily-bible-reading',
            ],
            [
                'title' => 'Do Not Fear',
                'bible_reference' => 'Isaiah 41:10',
                'bible_excerpt' => 'Do not fear, for I am with you.',
                'reflection' => 'God’s presence turns fear into courage and steadies the soul.',
                'action_step' => 'Repeat this verse when stress rises today.',
                'prayer' => 'Lord, strengthen me and remind me that You are with me. Amen.',
                'source_name' => 'USCCB Daily Bible Readings / Catholic Bible reference',
                'source_url' => 'https://bible.usccb.org/daily-bible-reading',
            ],
            [
                'title' => 'Remain in Me',
                'bible_reference' => 'John 15:5',
                'bible_excerpt' => 'Whoever remains in me and I in him will bear much fruit.',
                'reflection' => 'Prayer and closeness to Jesus are the roots of a fruitful Christian life.',
                'action_step' => 'Spend one quiet minute with Jesus before starting your day.',
                'prayer' => 'Jesus, help me remain in You and bear good fruit. Amen.',
                'source_name' => 'USCCB Daily Bible Readings / Catholic Bible reference',
                'source_url' => 'https://bible.usccb.org/daily-bible-reading',
            ],
            [
                'title' => 'Fruit of the Spirit',
                'bible_reference' => 'Galatians 5:22',
                'bible_excerpt' => 'The fruit of the Spirit is love, joy, peace.',
                'reflection' => 'The Holy Spirit shapes our words and actions so others can see Christ in us.',
                'action_step' => 'Choose one fruit of the Spirit to practice intentionally today.',
                'prayer' => 'Holy Spirit, grow Your fruit in my heart today. Amen.',
                'source_name' => 'USCCB Daily Bible Readings / Catholic Bible reference',
                'source_url' => 'https://bible.usccb.org/daily-bible-reading',
            ],
        ];

        foreach ($reflections as $index => $reflection) {
            DailyReflection::query()->updateOrCreate(
                [
                    'reflection_date' => $today->copy()->addDays($index)->toDateString(),
                ],
                $reflection
            );
        }
    }
}