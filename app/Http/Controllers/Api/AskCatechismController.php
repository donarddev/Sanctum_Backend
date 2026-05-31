<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\OllamaUnavailableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AskCatechism\AskCatechismRequest;
use App\Services\AskCatechismService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class AskCatechismController extends Controller
{
    public function __construct(
        private readonly AskCatechismService $askCatechismService
    ) {}

    public function ask(AskCatechismRequest $request): JsonResponse
    {
        try {
            $result = $this->askCatechismService->answer(
                $request->validated('question')
            );
        } catch (OllamaUnavailableException) {
            return ApiResponse::error(
                'Ask Catechism AI is unavailable. Please make sure Ollama is running.',
                ['ollama' => ['Unable to connect to Ollama.']],
                503
            );
        }

        return ApiResponse::success('Response generated.', $result);
    }
}
