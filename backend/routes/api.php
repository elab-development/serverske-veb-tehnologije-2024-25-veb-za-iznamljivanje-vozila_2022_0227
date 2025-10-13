<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::get('vehicles/search', [VehicleController::class, 'search']);
Route::get('vehicles/convert-price', [CurrencyController::class, 'convertPrice']);
Route::get('user/location', [VehicleController::class, 'getUserLocation']);

Route::get('vehicles', [VehicleController::class, 'index']);
Route::get('vehicles/{vehicle}/check-availability', [VehicleController::class, 'checkAvailability']);
Route::get('vehicles/{vehicle}/reservations', [ReservationController::class, 'reservationByVehicle']);
Route::get('vehicles/{vehicle}', [VehicleController::class, 'show']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::post('vehicles', [VehicleController::class, 'store']);
    Route::put('vehicles/{vehicle}', [VehicleController::class, 'update']);
    Route::patch('vehicles/{vehicle}', [VehicleController::class, 'update']);
    Route::delete('vehicles/{vehicle}', [VehicleController::class, 'destroy']);


    Route::get('reservations/export/csv', [ReservationController::class, 'exportCSV']);
    Route::get('reservations/statistics-join', [ReservationController::class, 'statisticsWithJoin']);
});
Route::get('reservations', [ReservationController::class, 'index']);
Route::get('reservations/{reservation}', [ReservationController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('users/{user}/reservations', [ReservationController::class, 'reservationByUser']);

    Route::post('reservations', [ReservationController::class, 'store']);
    Route::put('reservations/{reservation}', [ReservationController::class, 'update']);
    Route::patch('reservations/{reservation}', [ReservationController::class, 'update']);
    Route::delete('reservations/{reservation}', [ReservationController::class, 'destroy']);
});
