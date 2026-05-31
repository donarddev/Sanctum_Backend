<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rosary\StoreRosaryProgressRequest;
use App\Services\RosaryProgressService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RosaryProgressController extends Controller
{
    public function __construct(
        private readonly RosaryProgressService $rosaryProgressService
    ) {}

    public function index(Request $request): JsonResponse
    {
        return ApiResponse::success(
            'Rosary progress loaded.',
            $this->rosaryProgressService->getUserRosaryProgress($request->user())
        );
    }

    public function store(StoreRosaryProgressRequest $request): JsonResponse
    {
        $record = $this->rosaryProgressService->storeCompletedMystery(
            $request->user(),
            $request->validated()['mystery_name']
        );

        return ApiResponse::success(
            'Rosary progress saved.',
            [
                'mystery_name' => $record->mystery_name,
                'completed_count' => $record->completed_count,
                'completed_at' => $record->completed_at,
            ]
        );
    }
}