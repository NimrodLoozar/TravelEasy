<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Trip;
use Illuminate\Http\Request;
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
            $query->whereHas('trip', function ($q) use ($request) {
                $q->whereDate('departure_date', $request->departure_date);
            });
        }

        // Search by departure time
        if ($request->filled('departure_time')) {
            $query->whereHas('trip', function ($q) use ($request) {
                $q->where('departure_time', 'LIKE', $request->departure_time . '%');
            });
        }

        // Search by destination
        if ($request->filled('destination')) {
            $query->whereHas('trip.destination', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->destination . '%');
            });
        }

        $bookings = $query->paginate(10);
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create()
    {
        $customers = Customer::with('person')->get();
        $trips = Trip::with(['departure', 'destination'])->get();

        return view('bookings.create', compact('customers', 'trips'));
    }

    /**
     * Store a newly created booking.
     */
    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        // Transform the checkbox value
        $input = $request->all();
        $input['is_active'] = $request->has('is_active') ? true : false;

        $validator = Validator::make($input, [
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $booking = Booking::create($input);

        return redirect()->route('bookings.index')
            ->with('success', 'Boeking succesvol aangemaakt');
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        $booking->load(['customer.person', 'trip.departure', 'trip.destination']);
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit(Booking $booking)
    {
        $customers = Customer::with('person')->get();
        $trips = Trip::with(['departure', 'destination'])->get();

        return view('bookings.edit', compact('booking', 'customers', 'trips'));
    }

    /**
     * Update the specified booking.
     */
    public function update(Request $request, Booking $booking)
    {
        // Transform the checkbox value
        $input = $request->all();
        $input['is_active'] = $request->has('is_active') ? true : false;

        $validator = Validator::make($input, [
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $booking->update($input);

        return redirect()->route('bookings.index')
            ->with('success', 'Boeking succesvol bijgewerkt');
    }

    /**
     * Remove the specified booking.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Boeking succesvol verwijderd');
    }
}
