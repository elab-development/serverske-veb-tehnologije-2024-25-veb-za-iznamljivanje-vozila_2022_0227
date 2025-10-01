<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('vehicles/available', [VehicleController::class, 'available']);
Route::get('vehicles/search',    [VehicleController::class, 'search']);
Route::get('users/{user}/reservations', [ReservationController::class, 'reservationByUser']);

Route::apiResource('vehicles', VehicleController::class)->only(['index','show']);
Route::apiResource('reservations', ReservationController::class)->only(['index','show']);

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login',    [AuthController::class, 'login']);
Route::post('auth/logout',   [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('vehicles', VehicleController::class)->only(['store','update','destroy']);
    Route::apiResource('reservations', ReservationController::class)->only(['store','update','destroy']);
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
