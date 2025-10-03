<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;



class ReservationController extends Controller
{
    public function reservationByUser(User $user){
        $reservation = Reservation::query()->where('user_id',$user->id)->with('vehicle')->get();
        return response()->json($reservation);
    }
    public function index(Request $request)
    {
        $query = Reservation::with(['vehicle','user']);

        if($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if($request->has('vehicle_id')) {
            $query->where('vehicle_id',$request->vehicle_id);
        }

        if($request->has('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        if($request->has('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }
        if($request->has('min_price')) {
            $query->where('total_price', '>=', $request->min_price);
        }

        if($request->has('max_price')) {
            $query->where('total_price', '<=', $request->max_price);
        }

        $sortBy = $request->get('sort_by','created_at');
        $sortOrder = $request->get('sort_order','desc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->get('per_page',15);
        $reservations = $query->paginate($perPage);

        return response()->json($reservations);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_price' => 'required|numeric',
        ]);
        $reservation = Reservation::query()->create($validated);
        return response()->json($reservation, 201);
    }
    public function create()
    {
        //
    }
    public function show(Reservation $reservation)
    {
        return response()->json($reservation);
    }
    public function edit(Reservation $reservation)
    {

    }
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_price' => 'required|numeric',
        ]);
        $reservation->update($validated);
        return response()->json($reservation, 200);
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return response()->noContent();
    }

    public function exportCSV()
    {
        $reservations = Reservation::with(['user', 'vehicle'])->get();

        $filename = 'reservations_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($reservations) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'User', 'Email', 'Vehicle', 'Start Date', 'End Date', 'Price']);

            foreach ($reservations as $r) {
                fputcsv($file, [
                    $r->id,
                    $r->user->name,
                    $r->user->email,
                    $r->vehicle->brand . ' ' . $r->vehicle->model,
                    $r->start_date,
                    $r->end_date,
                    $r->total_price
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }





}
