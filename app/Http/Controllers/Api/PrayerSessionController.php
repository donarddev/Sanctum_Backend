<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrayerSession\StorePrayerSessionRequest;
use App\Http\Resources\PrayerSessionResource;
use App\Services\PrayerSessionService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
class PrayerSessionController extends Controller
{
    public function __construct(
        private readonly PrayerSessionService $prayerSessionService
    ) {}

    public function store(StorePrayerSessionRequest $request): JsonResponse
    {
        $session = $this->prayerSessionService->store(
            $request->user(),
            $request->validated()
        );

        return ApiResponse::success(
            'Prayer session saved successfully.',
            new PrayerSessionResource($session),
            201
        );
    }
}
