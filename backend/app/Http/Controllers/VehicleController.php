<?php

namespace App\Http\Controllers;


use App\Models\Reservation;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
class VehicleController extends Controller
{

    public function checkAvailability(Vehicle $vehicle, Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $isAvailable = !Reservation::query()->where('vehicle_id', $vehicle->id)
            ->where(function($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(function($q) use ($validated) {
                        $q->where('start_date', '<=', $validated['start_date'])
                            ->where('end_date', '>=', $validated['end_date']);
                    });
            })
            ->exists();

        return response()->json([
            'vehicle_id' => $vehicle->id,
            'available' => $isAvailable,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);
    }
    public function search(Request $request){
        $q = trim($request->query('q', ''));

        $result = Vehicle::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('brand', 'like', "%{$q}%")
                        ->orWhere('model', 'like', "%{$q}%")
                        ->orWhere('vehicle_type', $q);
                });
            })
            ->get();

        return response()->json($result);
    }
    public function index(Request $request)
    {
        $query = Vehicle::query();
        if($request->has('brand')){
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }
        if($request->has('model')){
            $query->where('model', 'like', '%' . $request->model . '%');
        }
        if($request->has('year')){
            $query->where('year', $request->year);
        }
        if($request->has('min_price')) {
            $query->where('price_per_day', '>=', $request->min_price);
        }
        if($request->has('max_price')) {
            $query->where('price_per_day', '<=', $request->max_price);
        }
        $sortBy = $request->get('sort_by','price_per_day');
        $sortOrder = $request->get('sort_order','asc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->get('per_page',10);
        $vehicles = $query->paginate($perPage);
        return response()->json($vehicles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json(['message' => 'Only admins can create vehicles'], 403);
        }
        $validate = $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'plate_number' => 'required|string|unique:vehicles,plate_number',
            'year' => 'required|digits:4',
            'price_per_day' => 'required|numeric',
            'fuel_type'     => 'nullable|in:petrol,diesel,hybrid,electric',
            'transmission'  => 'nullable|in:manual,automatic',
            'seats'         => 'nullable|integer|min:1|max:9',
            'tank_capacity' => 'nullable|numeric|min:0|max:100',
            'available' => 'required|boolean'
        ]);
        DB::beginTransaction();
        try {
            $vehicle = Vehicle::create($validate);
            DB::commit();
            return response()->json($vehicle, 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to create vehicle'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        return response()->json($vehicle);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json(['message' => 'Only admins can edit vehicles'], 403);
        }
        $data = $request->validate([
            'brand'         => 'sometimes|string',
            'model'         => 'sometimes|string',
            'plate_number'  => ['sometimes','string', Rule::unique('vehicles','plate_number')->ignore($vehicle->id)],
            'year'          => 'sometimes|integer|digits:4',
            'price_per_day' => 'sometimes|numeric',
            'fuel_type'     => 'sometimes|in:petrol,diesel,hybrid,electric|nullable',
            'transmission'  => 'sometimes|in:manual,automatic|nullable',
            'seats'         => 'sometimes|integer|min:1|max:9|nullable',
            'tank_capacity' => 'sometimes|numeric|min:0|max:100|nullable',
            'available'     => 'sometimes|boolean',
        ]);

        if (empty($data)) {
            return response()->json(['message' => 'No changes provided'], 422);
        }

        $vehicle->update($data);
        return response()->json($vehicle);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        DB::beginTransaction();

        try {
            $activeReservations = $vehicle->reservations()->count();

            if ($activeReservations > 0) {
                throw new \Exception('Cannot delete vehicle with active reservations');
            }

            $vehicle->delete();
            DB::commit();
            return response()->noContent();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getUserLocation(Request $request)
    {
        $ip = $request->ip();
//        if ($ip === '127.0.0.1' || $ip === '::1') {
//            $ip = '8.8.8.8';
//        }

        $response = Http::get("https://apiip.net/api/check", [
            'ip' => $ip,
            'accessKey' => 'a1e4bf61-08f1-425e-bcb9-3edbea44f5fc'
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to get location'], 500);
        }

        $data = $response->json();

        return response()->json([
            'ip' => $data['ip'] ?? 'N/A',
            'city' => $data['capital'] ?? 'N/A',
            'country' => $data['countryName'] ?? 'N/A',
            'country_code' => $data['countryCode'] ?? 'N/A',
            'latitude' => $data['latitude'] ?? 'N/A',
            'longitude' => $data['longitude'] ?? 'N/A',
            'continent' => $data['continentName'] ?? 'N/A',
            'phone_code' => $data['phoneCode'] ?? 'N/A',
            'message' => "Showing vehicles available in " . ($data['countryName'] ?? 'your location')
        ]);
    }
}
