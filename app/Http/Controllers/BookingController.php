<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the bookings.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'trip.departure', 'trip.destination']);

        // Search by departure date
        if ($request->filled('departure_date')) {
            $query->whereHas('trip', function($q) use ($request) {
                $q->whereDate('departure_date', $request->departure_date);
            });
        }

        // Search by departure time
        if ($request->filled('departure_time')) {
            $query->whereHas('trip', function($q) use ($request) {
                $q->where('departure_time', 'LIKE', $request->departure_time . '%');
            });
        }

        // Search by destination
        if ($request->filled('destination')) {
            $query->whereHas('trip.destination', function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->destination . '%');
            });
        }

        $bookings = $query->paginate(10)->withQueryString();
        return view('bookings.index', compact('bookings'));
    }


    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'trip_id' => 'required|exists:trips,id',
            'seat_number' => 'required|string',
            'purchase_date' => 'required|date',
            'purchase_time' => 'required',
            'booking_status' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
            'is_active' => 'boolean',
            'note' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $booking = Booking::create($request->all());

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        return response()->json([
            'booking' => $booking->load(['customer', 'trip'])
        ]);
    }

    /**
     * Update the specified booking.
     */
    public function update(Request $request, Booking $booking)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'exists:customers,id',
            'trip_id' => 'exists:trips,id',
            'seat_number' => 'string',
            'purchase_date' => 'date',
            'purchase_time' => 'date_format:H:i:s',
            'booking_status' => 'string',
            'price' => 'numeric|min:0',
            'quantity' => 'integer|min:1',
            'special_requests' => 'nullable|string',
            'is_active' => 'boolean',
            'note' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $booking->update($request->all());

        return response()->json([
            'message' => 'Booking updated successfully',
            'booking' => $booking
        ]);
    }

    /**
     * Remove the specified booking.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return response()->json([
            'message' => 'Booking deleted successfully'
        ]);
    }
}
