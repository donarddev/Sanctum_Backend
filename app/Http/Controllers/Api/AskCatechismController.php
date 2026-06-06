<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AskCatechism\AskCatechismRequest;
use App\Services\AskCatechismService;
use Illuminate\Http\JsonResponse;

class AskCatechismController extends Controller
{
    public function __construct(
        private readonly AskCatechismService $askCatechismService
    ) {}

    public function ask(AskCatechismRequest $request): JsonResponse
    {
        $result = $this->askCatechismService->answer(
            $request->validated('question')
        );

        $status = data_get($result, 'success', false) ? 200 : 503;

        return response()->json($result, $status);
    }
}
