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
        if (!$request->user()->isAdmin()) {
            return response()->json(['message' => 'Only admins can edit vehicles'], 403);
        }
        $data = $request->validate([
            'brand'         => 'sometimes|string',
            'model'         => 'sometimes|string',
            'plate_number'  => ['sometimes','string', Rule::unique('vehicles','plate_number')->ignore($vehicle->id)],
            'year'          => 'sometimes|integer|digits:4',
            'price_per_day' => 'sometimes|numeric',
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
        $vehicle->delete();
        return response()->noContent();
    }
}
