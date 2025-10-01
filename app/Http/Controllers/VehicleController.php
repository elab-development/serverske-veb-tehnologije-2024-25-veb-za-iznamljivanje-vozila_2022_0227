<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class VehicleController extends Controller
{
    public function available()
    {
        return response()->json(Vehicle::query()->where('available', true)->get());
    }
    public function search(Request $request){
        $q = $request->query('q', '');
        $result = Vehicle::query()->where('brand', 'like', '%'.$q.'%')->orWhere('model', 'like', '%'.$q.'%')->get();
        return response()->json($result);
    }
    public function index()
    {
        return response()->json(Vehicle::all());
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
        $validate = $request->validate([
           'brand' => 'required|string',
           'model' => 'required|string',
           'plate_number' => 'required|string|unique:vehicles,plate_number',
           'year' => 'required|digits:4',
           'price_per_day' => 'required|numeric',
           'available' => 'required|boolean'
        ]);
        $vehicle = Vehicle::query()->create($validate);
        return response()->json($vehicle);
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
        $validate = $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'plate_number'  => ['sometimes','string', Rule::unique('vehicles','plate_number')->ignore($vehicle->id)],
            'year' => 'required|digits:4',
            'price_per_day' => 'required|numeric',
            'available' => 'required|boolean'
        ]);
        if (empty($data)) {
            return response()->json(['message' => 'No changes provided'], 422);
        }
        $vehicle->update($validate);
        return response()->json($vehicle);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return response()->noContent();
    }
}
