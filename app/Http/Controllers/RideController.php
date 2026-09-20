<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Ride;
use App\Models\Driver;
use Illuminate\Support\Facades\Gate;

class RideController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pickup' => 'required|string',
            'destination' => 'required|string',
        ]);

        $ride = Ride::create([
            ...$validatedData,
            'user_id' => $request->user()->id,
        ]);
        return response()->json($ride, 201);
    }
    public function index(Request $request)
    {
        $rides = $request->user()->rides;

        return response()->json($rides);
    }
    public function show(Request $request, Ride $ride)
    {
        Gate::authorize('view', $ride);

        return response()->json($ride);
    }
    public function update(Request $request, Ride $ride)
    {
        Gate::authorize('update', $ride);

        $validatedData = $request->validate([
            'pickup' => 'required|string',
            'destination' => 'required|string',
            'status' => [
                'required',
                Rule::in([
                    'requested',
                    'accepted',
                    'arriving',
                    'in_progress',
                    'completed',
                    'cancelled',
                ]),
            ],
        ]);

        $ride->update($validatedData);

        return response()->json($ride);
    }
    public function destroy(Ride $ride)
    {

        Gate::authorize('delete', $ride);

        $ride->delete();

        return response()->json([
            'message' => 'Ride deleted successfully',
        ]);
    }
    public function updateStatus(Request $request, Ride $ride)
    {
        Gate::authorize('update', $ride);

        $validatedData = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'accepted',
                    'arriving',
                    'in_progress',
                    'completed',
                    'cancelled',
                ]),
            ],
        ]);

        $ride->update([
            'status' => $validatedData['status'],
        ]);

        return response()->json($ride);
    }
    public function accept(Ride $ride)
    {
        $driver = Driver::first();

        if (!$driver) {
            return response()->json([
                'message' => 'No driver available',
            ], 404);
        }

        $ride->update([
            'driver_id' => $driver->id,
            'status' => 'accepted',
        ]);

        return response()->json($ride);
    }
}
