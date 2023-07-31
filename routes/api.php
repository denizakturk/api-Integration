<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiEndpointTestingController;
use App\Http\Controllers\ApiRateLimitingController;
use App\Http\Controllers\ApiDataValidationController;
use App\Http\Controllers\ApiErrorHandlingController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::any('/authenticate', [ApiController::class, 'authenticate']);
Route::any('/api-endpoint', [ApiEndpointTestingController::class, 'apiEndpoint']);
Route::middleware('throttle:rate_limit,1')->group(function () {
    Route::any('/api-rate-limiting', [ApiRateLimitingController::class, 'apiRateLimiting']);
});
Route::any('/validate-api-data', [ApiDataValidationController::class, 'validateApiData']);
Route::any('/handle-api-error', [ApiErrorHandlingController::class, 'handleApiError']);
