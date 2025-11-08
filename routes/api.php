<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Guru Piket Routes
    Route::prefix('guru-piket')->group(function () {
        Route::get('/attendances', [\App\Http\Controllers\Api\GuruPiket\AttendanceController::class, 'index']);
        Route::put('/attendances/{id}', [\App\Http\Controllers\Api\GuruPiket\AttendanceController::class, 'update']);
        Route::post('/attendances/qr', [\App\Http\Controllers\Api\GuruPiket\AttendanceController::class, 'handleQrScan']);
    });
});
