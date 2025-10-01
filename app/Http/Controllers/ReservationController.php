<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function reservationByUser(User $user){
        $reservation = Reservation::query()->where('user_id',$user->id)->with('vehicle')->get();
        return response()->json($reservation);
    }
    public function index()
    {
        return response()->json(Reservation::all());
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
}
