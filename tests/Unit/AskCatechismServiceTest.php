<?php

namespace Tests\Unit;

use App\Services\AskCatechismService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AskCatechismServiceTest extends TestCase
{
    public function test_developer_questions_return_direct_developer_response(): void
    {
        $service = new AskCatechismService();

        $response = $service->answer('Who developed Sanctum?');

        $this->assertTrue($response['success']);
        $this->assertSame('Response generated.', $response['message']);
        $this->assertSame('developer_profile', $response['data']['source']);
        $this->assertSame([], $response['data']['references']);
        $this->assertStringContainsString('Donard Osol Lleno', $response['data']['answer']);
        $this->assertStringContainsString('dolleno@nemsu.edu.ph', $response['data']['answer']);
    }

    public function test_contact_questions_return_direct_developer_response(): void
    {
        $service = new AskCatechismService();

        $response = $service->answer('How can I contact the developer?');

        $this->assertTrue($response['success']);
        $this->assertSame('Response generated.', $response['message']);
        $this->assertSame('developer_profile', $response['data']['source']);
        $this->assertSame([], $response['data']['references']);
        $this->assertStringContainsString('donardlleno3@gmail.com', $response['data']['answer']);
    }

    public function test_unrelated_questions_still_use_the_catholic_filter(): void
    {
        $service = new AskCatechismService();

        $response = $service->answer('What is the capital of France?');

        $this->assertTrue($response['success']);
        $this->assertSame('Response generated.', $response['message']);
        $this->assertSame('catholic_filter', $response['data']['source']);
        $this->assertSame([], $response['data']['references']);
        $this->assertSame(
            'I’m here to help with Catholic faith, prayer, Scripture, Sacraments, saints, devotions, and spiritual guidance. Please ask a Catholic-related question.',
            $response['data']['answer']
        );
    }

    public function test_catholic_questions_use_gemini_when_the_api_key_is_present(): void
    {
        config([
            'services.gemini.api_key' => 'test-key',
            'services.gemini.model' => 'gemini-1.5-flash',
        ]);

        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                [
                                    'text' => 'Prayer is a conversation with God. It is rooted in Scripture and Catholic tradition. CCC 2558 and John 6:51 are relevant.',
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        $service = new AskCatechismService();

        $response = $service->answer('What is prayer?');

        $this->assertTrue($response['success']);
        $this->assertSame('Response generated.', $response['message']);
        $this->assertSame('gemini', $response['data']['source']);
        $this->assertStringContainsString('SHORT ANSWER', $response['data']['answer']);
        $this->assertStringContainsString('CATHOLIC EXPLANATION', $response['data']['answer']);
        $this->assertStringContainsString('CATHOLIC REMINDER', $response['data']['answer']);
        $this->assertStringContainsString('Prayer is a conversation with God. It is rooted in Scripture and Catholic tradition.', $response['data']['answer']);
        $this->assertContains('CCC 2558', $response['data']['references']);
        $this->assertContains('John 6:51', $response['data']['references']);
        Http::assertSentCount(1);
    }

    public function test_gemini_responses_are_wrapped_when_the_headings_are_missing(): void
    {
        config([
            'services.gemini.api_key' => 'test-key',
            'services.gemini.model' => 'gemini-1.5-flash',
        ]);

        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                [
                                    'text' => 'The Eucharist is the source and summit of the Christian life. CCC 1324 and John 6:51 are relevant.',
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        $service = new AskCatechismService();

        $response = $service->answer('What is the Eucharist?');

        $this->assertTrue($response['success']);
        $this->assertSame('gemini', $response['data']['source']);
        $this->assertStringStartsWith("SHORT ANSWER\n", $response['data']['answer']);
        $this->assertStringContainsString('CATHOLIC EXPLANATION', $response['data']['answer']);
        $this->assertStringContainsString('CATHOLIC REMINDER', $response['data']['answer']);
        $this->assertContains('CCC 1324', $response['data']['references']);
        $this->assertContains('John 6:51', $response['data']['references']);
    }

    public function test_gemini_failures_return_the_fallback_payload(): void
    {
        config([
            'services.gemini.api_key' => 'test-key',
            'services.gemini.model' => 'gemini-1.5-flash',
        ]);

        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([], 500),
        ]);

        $service = new AskCatechismService();

        $response = $service->answer('What is the Eucharist?');

        $this->assertFalse($response['success']);
        $this->assertSame('Ask Catechism AI is temporarily unavailable. Please try again later.', $response['message']);
        $this->assertSame('fallback', $response['data']['source']);
        $this->assertSame([], $response['data']['references']);
        $this->assertSame(
            'Ask Catechism AI is temporarily unavailable. You may still explore the Prayer Library, Daily Reflection, Rosary Guide, and Confession Guide. Please try again later.',
            $response['data']['answer']
        );
    }
}
