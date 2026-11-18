<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PortalApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| DPCC ERP API Routes (v1)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Health check
    Route::get('/health', fn () => response()->json([
        'status' => 'healthy',
        'institution' => 'D.P. Chaturvedi College, Seoni (MP)',
        'institution_code' => 'JS-499',
        'api_version' => '1.0.0',
        'timestamp' => now()->toIso8601String(),
    ]));

    // Public Authentication
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Authenticated Endpoints
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        // Mobile Portals
        Route::get('/student/dashboard', [PortalApiController::class, 'studentDashboard']);
        Route::get('/timetable', [PortalApiController::class, 'timetable']);
        Route::get('/notifications', [PortalApiController::class, 'notifications']);
    });
});
