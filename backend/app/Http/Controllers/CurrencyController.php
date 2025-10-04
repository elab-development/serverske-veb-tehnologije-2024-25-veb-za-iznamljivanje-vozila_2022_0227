<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    public function convertPrice(Request $request): \Illuminate\Http\JsonResponse
    {
        $vehicleId = $request->vehicle_id;
        $currency = $request->get('currency', 'USD');

        $vehicle = Vehicle::query()->find($vehicleId);

        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }

        $response = Http::get("https://api.exchangerate-api.com/v4/latest/EUR");

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch exchange rates'], 500);
        }

        $rates = $response->json()['rates'];
        $rate = $rates[$currency] ?? 1;

        $converted = $vehicle->price_per_day * $rate;
        $converted = number_format($converted, 2, '.', ''); // Format umesto round

        return response()->json([
            'vehicle' => $vehicle->brand . ' ' . $vehicle->model,
            'price_eur' => $vehicle->price_per_day . ' EUR',
            'price_converted' => $converted . ' ' . $currency,
            'exchange_rate' => $rate
        ]);
    }
}
