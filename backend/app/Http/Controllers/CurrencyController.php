<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    public function convertPrice(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'from' => 'required|string|size:3',
            'to' => 'required|string|size:3',
        ]);

        $response = Http::get("https://api.exchangerate-api.com/v4/latest/{$validated['from']}");

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch exchange rates'], 500);
        }

        $data = $response->json();

        if (!isset($data['rates'][$validated['to']])) {
            return response()->json(['error' => 'Invalid currency code'], 400);
        }

        $rate = $data['rates'][$validated['to']];
        $converted = $validated['amount'] * $rate;

        return response()->json([
            'original_amount' => $validated['amount'],
            'from_currency' => $validated['from'],
            'to_currency' => $validated['to'],
            'exchange_rate' => $rate,
            'converted_amount' => $converted,
            'timestamp' => now()->toIso8601String()
        ]);
    }
}
