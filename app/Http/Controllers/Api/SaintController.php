<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SaintResource;
use App\Services\SaintService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaintController extends Controller
{
    public function __construct(
        private readonly SaintService $saintService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $saint = $this->saintService->getSaintOfTheDay();

        return ApiResponse::success(
            'Saint of the day loaded.',
            new SaintResource($saint)
        );
    }
}