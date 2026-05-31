<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DailyReflectionResource;
use App\Http\Resources\SaintResource;
use App\Services\HomeService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        private readonly HomeService $homeService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $homeData = $this->homeService->getHomeData($request->user());

        return ApiResponse::success('Home data loaded.', [
            'today_progress' => $homeData['today_progress'],
            'dashboard_stats' => $homeData['dashboard_stats'],
            'daily_reflection' => new DailyReflectionResource($homeData['daily_reflection']),
            'saint_of_the_day' => new SaintResource($homeData['saint_of_the_day']),
            'mood_recommendations' => $homeData['mood_recommendations'],
        ]);
    }
}