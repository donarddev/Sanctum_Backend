<?php

namespace App\Services;

use App\Exceptions\OllamaUnavailableException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AskCatechismService
{
    private const REFUSAL_ANSWER = 'I can only answer questions related to Catholic faith, prayer, Scripture, sacraments, saints, and the Catechism of the Catholic Church.';

    private const CATHOLIC_KEYWORDS = [
        'catholic', 'church', 'god', 'jesus', 'christ', 'holy spirit', 'trinity',
        'bible', 'scripture', 'gospel', 'catechism', 'ccc', 'sacrament', 'eucharist',
        'mass', 'confession', 'penance', 'baptism', 'confirmation', 'communion',
        'anointing', 'holy orders', 'matrimony', 'mary', 'rosary', 'saint', 'saints',
        'prayer', 'sin', 'mortal sin', 'venial sin', 'grace', 'salvation', 'priest',
        'pope', 'liturgy', 'lent', 'advent', 'easter', 'christmas', 'heaven', 'hell',
        'purgatory', 'commandments', 'morality', 'vocation', 'faith',
    ];

    /**
     * @var array<int, array{keywords: array<int, string>, references: array<int, string>, summary: string}>
     */
    private const CCC_CONTEXTS = [
        [
            'keywords' => ['eucharist', 'communion', 'body and blood', 'mass'],
            'references' => ['CCC 1324', 'CCC 1374'],
            'summary' => 'The Eucharist is central to Catholic life. Catholics believe Christ is truly present in the Eucharist.',
        ],
        [
            'keywords' => ['confession', 'penance', 'reconciliation', 'priest', 'forgive sins'],
            'references' => ['CCC 1422', 'CCC 1441', 'CCC 1461'],
            'summary' => 'The Sacrament of Penance reconciles the faithful with God and the Church. The priest serves as minister of God\'s mercy.',
        ],
        [
            'keywords' => ['rosary', 'hail mary', 'mysteries'],
            'references' => ['CCC 971', 'CCC 2678'],
            'summary' => 'The Rosary is a Marian devotion centered on meditation on the mysteries of Christ\'s life.',
        ],
        [
            'keywords' => ['mary', 'mother of god', 'blessed virgin', 'intercession'],
            'references' => ['CCC 487', 'CCC 971', 'CCC 2677'],
            'summary' => 'Catholics honor Mary because of her unique role as Mother of Jesus. Worship belongs to God alone.',
        ],
        [
            'keywords' => ['mortal sin', 'grave sin', 'venial sin'],
            'references' => ['CCC 1855', 'CCC 1857', 'CCC 1862'],
            'summary' => 'Mortal sin involves grave matter, full knowledge, and deliberate consent. Venial sin weakens charity but does not destroy it.',
        ],
        [
            'keywords' => ['seven sacraments', 'sacraments'],
            'references' => ['CCC 1113', 'CCC 1210'],
            'summary' => 'The seven sacraments are signs of grace instituted by Christ and entrusted to the Church.',
        ],
        [
            'keywords' => ['baptism', 'baptized', 'original sin'],
            'references' => ['CCC 1213', 'CCC 1272'],
            'summary' => 'Baptism is the first sacrament of initiation and marks a person as belonging to Christ.',
        ],
        [
            'keywords' => ['prayer', 'pray', 'praying'],
            'references' => ['CCC 2558', 'CCC 2565'],
            'summary' => 'Prayer is a living relationship with God and an expression of faith.',
        ],
        [
            'keywords' => ['trinity', 'father son holy spirit', 'three persons'],
            'references' => ['CCC 232', 'CCC 253'],
            'summary' => 'Catholics believe in one God in three Divine Persons: Father, Son, and Holy Spirit.',
        ],
    ];

    /**
     * @return array{answer: string, source: string, references: array<int, string>}
     *
     * @throws OllamaUnavailableException
     */
    public function answer(string $question): array
    {
        if (! $this->isCatholicRelated($question)) {
            return [
                'answer' => self::REFUSAL_ANSWER,
                'source' => 'filter',
                'references' => [],
            ];
        }

        $context = $this->resolveContext($question);
        $answer = $this->askOllama($question, $context);

        return [
            'answer' => $answer,
            'source' => 'ollama',
            'references' => $context['references'],
        ];
    }

    private function isCatholicRelated(string $question): bool
    {
        $normalized = Str::lower($question);

        foreach (self::CATHOLIC_KEYWORDS as $keyword) {
            if (Str::contains($normalized, Str::lower($keyword))) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array{summaries: array<int, string>, references: array<int, string>, has_specific_context: bool}
     */
    private function resolveContext(string $question): array
    {
        $normalized = Str::lower($question);
        $summaries = [];
        $references = [];

        foreach (self::CCC_CONTEXTS as $entry) {
            if ($this->matchesAnyKeyword($normalized, $entry['keywords'])) {
                $summaries[] = $entry['summary'];
                $references = array_merge($references, $entry['references']);
            }
        }

        $references = array_values(array_unique($references));

        if ($summaries === []) {
            return [
                'summaries' => [
                    'No specific local Catechism excerpt was matched. Answer carefully using general Catholic teaching. Do not invent CCC paragraph numbers.',
                ],
                'references' => [],
                'has_specific_context' => false,
            ];
        }

        return [
            'summaries' => array_values(array_unique($summaries)),
            'references' => $references,
            'has_specific_context' => true,
        ];
    }

    /**
     * @param  array<int, string>  $keywords
     */
    private function matchesAnyKeyword(string $normalizedQuestion, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (Str::contains($normalizedQuestion, Str::lower($keyword))) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  array{summaries: array<int, string>, references: array<int, string>, has_specific_context: bool}  $context
     *
     * @throws OllamaUnavailableException
     */
    private function askOllama(string $question, array $context): string
    {
        $baseUrl = rtrim((string) config('services.ollama.base_url'), '/');
        $model = (string) config('services.ollama.model');

        $userContent = $this->buildUserMessage($question, $context);

        try {
            $response = Http::timeout(120)
                ->acceptJson()
                ->post("{$baseUrl}/api/chat", [
                    'model' => $model,
                    'stream' => false,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $this->buildSystemPrompt(),
                        ],
                        [
                            'role' => 'user',
                            'content' => $userContent,
                        ],
                    ],
                ]);
        } catch (\Throwable) {
            throw new OllamaUnavailableException('Unable to connect to Ollama.');
        }

        if (! $response->successful()) {
            throw new OllamaUnavailableException('Unable to connect to Ollama.');
        }

        $content = data_get($response->json(), 'message.content');

        if (! is_string($content) || trim($content) === '') {
            throw new OllamaUnavailableException('Ollama returned an empty response.');
        }

        return trim($content);
    }

    private function buildSystemPrompt(): string
    {
        return <<<'PROMPT'
You are Ask Catechism, a Catholic faith Q&A assistant inside the Sanctum app.

You answer questions about Catholic beliefs, prayer, Scripture, sacraments, saints, moral teachings, and the Catechism of the Catholic Church.

Rules:
1. Answer only Catholic-related questions.
2. Use only the provided Catholic/Catechism context when specific context is available.
3. Do not invent doctrine.
4. Do not invent CCC paragraph numbers.
5. Include CCC paragraph references only when provided in the context.
6. Use respectful, pastoral, beginner-friendly language.
7. If the context is insufficient, say that the answer is general and should be verified with the Catechism, a priest, or a catechist.
8. Do not replace a priest, confessor, catechist, doctor, therapist, or spiritual director.
9. For personal confession, moral crisis, mental health, or emergency concerns, recommend speaking with a priest or trusted professional.

Response format:
Short Answer
[answer]

Catholic Explanation
[explanation]

Catechism Reference
[CCC references if available, otherwise say: Not available in the provided local context.]

Gentle Reminder
[short pastoral reminder]
PROMPT;
    }

    /**
     * @param  array{summaries: array<int, string>, references: array<int, string>, has_specific_context: bool}  $context
     */
    private function buildUserMessage(string $question, array $context): string
    {
        $summaryBlock = implode("\n", array_map(
            fn (string $summary) => "- {$summary}",
            $context['summaries']
        ));

        $referenceBlock = $context['references'] !== []
            ? implode(', ', $context['references'])
            : 'None provided in local context.';

        return <<<MESSAGE
CCC CONTEXT:
{$summaryBlock}

CCC REFERENCES (use only these when citing paragraphs):
{$referenceBlock}

USER QUESTION:
{$question}
MESSAGE;
    }
}
