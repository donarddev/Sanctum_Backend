<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $stats = $this->dashboardService->getStats($request->user());

        return ApiResponse::success(
            'Dashboard stats retrieved successfully.',
            $stats
        );
    }
}
