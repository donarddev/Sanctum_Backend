<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Services\AskCatechismService;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AskCatechismControllerTest extends TestCase
{
    use WithFaker;

    public function test_ask_catechism_returns_the_standard_json_envelope(): void
    {
        Sanctum::actingAs(User::factory()->make());

        $this->mock(AskCatechismService::class, function ($mock): void {
            $mock->shouldReceive('answer')
                ->once()
                ->with('Who developed Sanctum?')
                ->andReturn([
                    'answer' => 'Test developer response.',
                    'source' => 'developer_profile',
                    'references' => [],
                ]);
        });

        $response = $this->postJson('/api/ask-catechism', [
            'question' => 'Who developed Sanctum?',
        ]);

        $response->assertOk();
        $response->assertExactJson([
            'success' => true,
            'message' => 'Response generated.',
            'data' => [
                'answer' => 'Test developer response.',
                'source' => 'developer_profile',
                'references' => [],
            ],
        ]);
    }
}
