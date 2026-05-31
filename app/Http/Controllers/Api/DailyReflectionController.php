<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DailyReflection\MarkDailyReflectionReadRequest;
use App\Http\Resources\DailyReflectionResource;
use App\Services\DailyReflectionService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DailyReflectionController extends Controller
{
    public function __construct(
        private readonly DailyReflectionService $dailyReflectionService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $reflection = $this->dailyReflectionService->getDailyReflectionForToday();

        return ApiResponse::success(
            'Daily reflection loaded.',
            new DailyReflectionResource($reflection)
        );
    }

    public function read(MarkDailyReflectionReadRequest $request): JsonResponse
    {
        $read = $this->dailyReflectionService->markTodayAsRead($request->user());

        if ($read === null) {
            return ApiResponse::error(
                'No stored daily reflection is available to mark as read.',
                null,
                404
            );
        }

        return ApiResponse::success(
            'Reflection marked as read.',
            [
                'read_reflection_today' => true,
            ]
        );
    }
}