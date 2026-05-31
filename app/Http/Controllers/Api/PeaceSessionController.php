<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PeaceSession\StorePeaceSessionRequest;
use App\Http\Resources\PeaceSessionResource;
use App\Services\PeaceSessionService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class PeaceSessionController extends Controller
{
    public function __construct(
        private readonly PeaceSessionService $peaceSessionService
    ) {}

    public function store(StorePeaceSessionRequest $request): JsonResponse
    {
        $session = $this->peaceSessionService->store(
            $request->user(),
            $request->validated()
        );

        return ApiResponse::success(
            'Peace session saved successfully.',
            new PeaceSessionResource($session),
            201
        );
    }
}
