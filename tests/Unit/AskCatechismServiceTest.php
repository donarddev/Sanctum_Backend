<?php

namespace Tests\Unit;

use App\Services\AskCatechismService;
use Tests\TestCase;

class AskCatechismServiceTest extends TestCase
{
    public function test_developer_questions_return_direct_developer_response(): void
    {
        $service = new AskCatechismService();

        $response = $service->answer('Who developed Sanctum?');

        $this->assertSame('developer_profile', $response['source']);
        $this->assertSame([], $response['references']);
        $this->assertStringContainsString('Donard Osol Lleno', $response['answer']);
        $this->assertStringContainsString('dolleno@nemsu.edu.ph', $response['answer']);
    }

    public function test_contact_questions_return_direct_developer_response(): void
    {
        $service = new AskCatechismService();

        $response = $service->answer('How can I contact the developer?');

        $this->assertSame('developer_profile', $response['source']);
        $this->assertSame([], $response['references']);
        $this->assertStringContainsString('donardlleno3@gmail.com', $response['answer']);
    }

    public function test_unrelated_questions_still_use_the_catholic_filter(): void
    {
        $service = new AskCatechismService();

        $response = $service->answer('What is the capital of France?');

        $this->assertSame('filter', $response['source']);
        $this->assertSame([], $response['references']);
        $this->assertSame(
            'I can only answer questions related to Catholic faith, prayer, Scripture, sacraments, saints, and the Catechism of the Catholic Church.',
            $response['answer']
        );
    }
}
