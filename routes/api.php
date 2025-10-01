<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('vehicles', VehicleController::class);
Route::resource('reservations', ReservationController::class);



Route::get('vehicles/available', [VehicleController::class, 'available']);
Route::get('vehicles/search', [VehicleController::class, 'search']);
Route::get('users/{user}/reservations', [ReservationController::class, 'reservationByUser']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
